<div class="pointer-events-none fixed inset-x-0 top-0 z-[100] flex flex-col items-center gap-3 p-4 sm:bottom-auto sm:left-auto sm:right-0 sm:top-16 sm:w-full sm:max-w-md" id="toast-container"></div>

<style>
  @keyframes toast-progress {
    from {
      width: 100%;
    }
    to {
      width: 0%;
    }
  }

  .toast-progress-bar {
    animation: toast-progress linear forwards;
  }

  .toast-in {
    animation: toast-slide-in 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  }

  .toast-out {
    animation: toast-slide-out 0.3s ease-in forwards;
  }

  @keyframes toast-slide-in {
    from {
      transform: translateX(100%);
      opacity: 0;
    }
    to {
      transform: translateX(0);
      opacity: 1;
    }
  }

  @keyframes toast-slide-out {
    from {
      transform: translateX(0);
      opacity: 1;
    }
    to {
      transform: translateX(20px);
      opacity: 0;
    }
  }

  @media (max-width: 640px) {
    @keyframes toast-slide-in {
      from {
        transform: translateY(-20px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }
  }
</style>

<script>
  window.showToast = function (type, message, duration = null) {
    const container = document.getElementById("toast-container");
    if (!container) return;

    const toastConfig = {
      success: {
        bg: "bg-emerald-50/90 dark:bg-emerald-950/90",
        border: "border-emerald-200 dark:border-emerald-800",
        text: "text-emerald-800 dark:text-emerald-200",
        accent: "bg-emerald-500",
        icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />',
        duration: 5000,
      },
      error: {
        bg: "bg-rose-50/90 dark:bg-rose-950/90",
        border: "border-rose-200 dark:border-rose-800",
        text: "text-rose-800 dark:text-rose-200",
        accent: "bg-rose-500",
        icon: '<path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />',
        duration: 8000,
      },
      warning: {
        bg: "bg-amber-50/90 dark:bg-amber-950/90",
        border: "border-amber-200 dark:border-amber-800",
        text: "text-amber-800 dark:text-amber-200",
        accent: "bg-amber-500",
        icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />',
        duration: 6000,
      },
      info: {
        bg: "bg-blue-50/90 dark:bg-blue-950/90",
        border: "border-blue-200 dark:border-blue-800",
        text: "text-blue-800 dark:text-blue-200",
        accent: "bg-blue-500",
        icon: '<path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12v-.008Z" />',
        duration: 5000,
      },
    };

    const config = toastConfig[type] || toastConfig.info;
    const toastDuration = duration !== null ? duration : config.duration;

    const toast = document.createElement("div");
    toast.className = `pointer-events-auto relative w-full overflow-hidden rounded-xl border ${config.border} ${config.bg} ${config.text} backdrop-blur-md shadow-2xl toast-in`;
    toast.setAttribute("role", "alert");

    toast.innerHTML = `
      <div class="flex items-start p-4">
        <div class="flex-shrink-0">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
            ${config.icon}
          </svg>
        </div>
        <div class="ml-3 pr-8 flex-1">
          <p class="text-sm font-medium leading-5">${message}</p>
        </div>
        <button type="button" class="absolute right-2 top-2 inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors hover:bg-black/5 dark:hover:bg-white/10">
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <!-- Progress Bar -->
      <div class="absolute bottom-0 left-0 h-[3px] w-full bg-black/5 dark:bg-white/10">
        <div class="toast-progress-bar h-full ${config.accent}" style="animation-duration: ${toastDuration}ms"></div>
      </div>
    `;

    container.prepend(toast);

    const remove = () => {
      toast.classList.replace("toast-in", "toast-out");
      toast.addEventListener("animationend", () => toast.remove());
    };

    const timeoutId = setTimeout(remove, toastDuration);

    toast.querySelector("button").onclick = () => {
      clearTimeout(timeoutId);
      remove();
    };
  };

  document.addEventListener("DOMContentLoaded", function () {
    @if (!isset($exception))
      @if (session('success'))
        window.showToast('success', "{{ session('success') }}");
      @endif
      @if (session('error'))
        window.showToast('error', "{{ session('error') }}");
      @endif
      @if ($errors->any())
        @foreach ($errors->all() as $error)
          window.showToast('error', "{{ $error }}");
        @endforeach
      @endif
      @if (session('warning'))
        window.showToast('warning', "{{ session('warning') }}");
      @endif
      @if (session('info'))
        window.showToast('info', "{{ session('info') }}");
      @endif
    @endif
  });
</script>