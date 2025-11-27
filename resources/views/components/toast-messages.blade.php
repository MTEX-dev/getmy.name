<div
    class="fixed top-24 right-5 z-50 w-[450px] space-y-4"
    id="toast-container"
></div>

<style>
    [x-transition:enter] {
        transition-property: transform, opacity;
        transition-duration: 300ms;
        transition-timing-function: ease-out;
    }

    [x-transition:leave] {
        transition-property: transform, opacity;
        transition-duration: 300ms;
        transition-timing-function: ease-in;
    }

    [x-transition:enter].slide-in {
        opacity: 0;
        transform: translateX(100%);
    }

    [x-transition:enter-start].slide-in {
        opacity: 0;
        transform: translateX(100%);
    }

    [x-transition:enter-end].slide-in {
        opacity: 1;
        transform: translateX(0);
    }

    [x-transition:leave].slide-out {
        opacity: 1;
        transform: translateX(0);
    }

    [x-transition:leave-start].slide-out {
        opacity: 1;
        transform: translateX(0);
    }

    [x-transition:leave-end].slide-out {
        opacity: 0;
        transform: translateX(100%);
    }
</style>

<script>
    window.showToast = function (type, message, duration = null) {
        const container = document.getElementById('toast-container');
        if (!container) {
            console.error('Toast container not found');
            return;
        }

        const toastConfig = {
            success: {
                bgColor: 'bg-green-100 dark:bg-green-700',
                textColor: 'text-green-600 dark:text-green-200',
                icon: '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>',
                duration: 5000,
            },
            error: {
                bgColor: 'bg-red-100 dark:bg-red-700',
                textColor: 'text-red-600 dark:text-red-200',
                icon: '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>',
                duration: 10000,
            },
            warning: {
                bgColor: 'bg-orange-100 dark:bg-orange-700',
                textColor: 'text-orange-600 dark:text-orange-200',
                icon: '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>',
                duration: 5000,
            },
            info: {
                bgColor: 'bg-blue-100 dark:bg-blue-700',
                textColor: 'text-blue-600 dark:text-blue-200',
                icon: '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>',
                duration: 5000,
            },
        };

        const config = toastConfig[type] || toastConfig.info;
        const toastDuration = duration !== null ? duration : config.duration;
        const toastId = 'toast-dynamic-' + Date.now();

        const toast = document.createElement('div');
        toast.id = toastId;
        toast.className =
            'flex w-full items-center rounded-lg border border-gray-200 bg-white p-4 pe-5 text-gray-700 shadow-lg dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-all duration-300 ease-in-out transform hover:scale-105';
        toast.setAttribute('role', 'alert');
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';

        toast.innerHTML = `
            <div class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg ${config.bgColor} ${config.textColor}">
                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    ${config.icon}
                </svg>
            </div>
            <div class="ms-3 text-sm font-normal">${message}</div>
            <button type="button" class="-mx-1.5 -my-1.5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-white p-1.5 text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        `;

        container.prepend(toast);

        setTimeout(() => {
            toast.style.transition = 'all 300ms ease-out';
            toast.style.opacity = '1';
            toast.style.transform = 'translateX(0)';
        }, 10);

        const timeoutId = setTimeout(() => {
            removeToast(toast);
        }, toastDuration);

        const closeBtn = toast.querySelector('button');
        closeBtn.addEventListener('click', () => {
            clearTimeout(timeoutId);
            removeToast(toast);
        });

        function removeToast(toastEl) {
            toastEl.style.transition = 'all 300ms ease-in';
            toastEl.style.opacity = '0';
            toastEl.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (toastEl.parentNode) {
                    toastEl.parentNode.removeChild(toastEl);
                }
            }, 300);
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        @if (!isset($exception))
            @if (session('success'))
                window.showToast('success', "{{ session('success') }}");
            @endif

            @if (session('error'))
                window.showToast('error', "{{ session('error') }}");
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    window.showToast('error', "{{ $error }}", 10000);
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