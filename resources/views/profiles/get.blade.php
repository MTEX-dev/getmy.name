<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>{{ $data["name"] }} - {{ $data["title"] }}</title>
		<script src="https://cdn.tailwindcss.com"></script>
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap"
			rel="stylesheet"
		/>
		<style>
			body {
				font-family: "Inter", sans-serif;
			}
			.gradient-text {
				background: linear-gradient(to right, #6ee7b7, #3b82f6, #9333ea);
				-webkit-background-clip: text;
				-webkit-text-fill-color: transparent;
				background-clip: text;
				text-fill-color: transparent;
			}
		</style>
	</head>
	<body class="bg-gray-900 text-gray-300 antialiased">
		<!-- Top Navigation Bar -->
		<nav class="fixed top-0 right-0 z-50 p-6">
			@auth
				<div class="relative group">
					<!-- Avatar Button -->
					<button class="flex items-center space-x-2 rounded-full bg-gray-800/80 backdrop-blur-sm border border-gray-700 p-2 hover:border-emerald-500/50 transition-all duration-200">
						<img 
							src="{{ Auth::user()->avatar() }}" 
							alt="{{ Auth::user()->name }}" 
							class="h-8 w-8 rounded-full object-cover border border-emerald-500"
						/>
						<svg class="h-4 w-4 text-gray-400 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
						</svg>
					</button>
					
					<!-- Dropdown Menu -->
					<div class="absolute right-0 mt-2 w-64 origin-top-right rounded-lg bg-gray-800 border border-gray-700 shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform scale-95 group-hover:scale-100">
						<div class="p-4 border-b border-gray-700">
							<div class="flex items-center space-x-3">
								<img 
									src="{{ Auth::user()->avatar() }}" 
									alt="{{ Auth::user()->name }}" 
									class="h-10 w-10 rounded-full object-cover border border-emerald-500"
								/>
								<div>
									<p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
									<p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
								</div>
							</div>
						</div>
						<div class="p-2">
							<a href="{{ route('profile.edit') }}" class="flex items-center w-full px-3 py-2 text-sm text-gray-300 rounded-md hover:bg-gray-700 hover:text-emerald-400 transition-colors">
								<svg class="h-4 w-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
								</svg>
								Profile
							</a>
							<a href="{{ route('dashboard') }}" class="flex items-center w-full px-3 py-2 text-sm text-gray-300 rounded-md hover:bg-gray-700 hover:text-emerald-400 transition-colors">
								<svg class="h-4 w-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
								</svg>
								Dashboard
							</a>
							<a href="{{ route('profile.preview') }}" class="flex items-center w-full px-3 py-2 text-sm text-gray-300 rounded-md hover:bg-gray-700 hover:text-emerald-400 transition-colors">
								<svg class="h-4 w-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
								</svg>
								Preview Portfolio
							</a>
						</div>
						<div class="p-2 border-t border-gray-700">
							<form method="POST" action="{{ route('logout') }}">
								@csrf
								<button type="submit" class="flex items-center w-full px-3 py-2 text-sm text-red-400 rounded-md hover:bg-gray-700 hover:text-red-300 transition-colors">
									<svg class="h-4 w-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
									</svg>
									Sign Out
								</button>
							</form>
						</div>
					</div>
				</div>
			@endauth

			@guest
				<div class="flex items-center space-x-4">
					<a href="{{ route('login') }}" class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-200">
						<svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
						</svg>
						Log In
					</a>
				</div>
			@endguest
		</nav>

		<div class="container mx-auto max-w-6xl p-6 lg:p-12 pt-20">
			<main class="grid grid-cols-1 gap-12 lg:grid-cols-3">
				<aside class="self-start lg:sticky lg:top-12 lg:col-span-1">
					<div class="flex flex-col space-y-6">
						<header class="text-center lg:text-left">
							@if (isset($data["avatar_url"]) && $data["avatar_url"])
								<div class="mb-4 flex justify-center lg:justify-start">
									<img
										src="{{ $data['avatar_url'] }}"
										alt="{{ $data['name'] }}"
										class="h-24 w-24 rounded-full border-2 border-emerald-500 object-cover"
									/>
								</div>
							@endif
							<h1 class="text-4xl font-black text-white">
								{{ $data["name"] }}
							</h1>
							<h2 class="gradient-text mt-1 text-xl font-medium">
								{{ $data["title"] }}
							</h2>
							@if (isset($data["bio"]) && $data["bio"])
								<p class="mt-4 text-gray-400">
									{{ $data["bio"] }}
								</p>
							@else
								<p class="mt-4 text-gray-400">
									Building elegant solutions for the web, one line of code at a
									time.
								</p>
							@endif
							@if (isset($data["location"]) && $data["location"])
								<p class="mt-2 text-sm text-gray-500">
									📍 {{ $data["location"] }}
								</p>
							@endif
						</header>

						<div class="flex items-center justify-center space-x-4 lg:justify-start">
							@if (isset($data["socials"]["github"]))
								<a
									href="https://github.com/{{ $data['socials']['github'] }}"
									target="_blank"
									rel="noopener noreferrer"
									class="text-gray-400 transition-colors hover:text-white"
								>
									<span class="sr-only">GitHub</span>
									<svg
										class="h-6 w-6"
										fill="currentColor"
										viewBox="0 0 24 24"
										aria-hidden="true"
									>
										<path
											fill-rule="evenodd"
											d="M12 2C6.477 2 2 6.477 2 12c0 4.418 2.865 8.168 6.839 9.49.5.092.682-.217.682-.482 0-.237-.009-.868-.014-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.031-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.03 1.595 1.03 2.688 0 3.848-2.338 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.001 10.001 0 0022 12c0-5.523-4.477-10-10-10z"
											clip-rule="evenodd"
										/>
									</svg>
								</a>
							@endif
							@if (isset($data["socials"]["linkedin"]))
								<a
									href="https://linkedin.com/in/{{ $data['socials']['linkedin'] }}"
									target="_blank"
									rel="noopener noreferrer"
									class="text-gray-400 transition-colors hover:text-white"
								>
									<span class="sr-only">LinkedIn</span>
									<svg
										class="h-6 w-6"
										fill="currentColor"
										viewBox="0 0 24 24"
										aria-hidden="true"
									>
										<path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
									</svg>
								</a>
							@endif
							@if (isset($data["socials"]["twitter"]))
								<a
									href="https://twitter.com/{{ $data['socials']['twitter'] }}"
									target="_blank"
									rel="noopener noreferrer"
									class="text-gray-400 transition-colors hover:text-white"
								>
									<span class="sr-only">Twitter</span>
									<svg
										class="h-6 w-6"
										fill="currentColor"
										viewBox="0 0 24 24"
										aria-hidden="true"
									>
										<path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
									</svg>
								</a>
							@endif
							@if (isset($data["socials"]["personal_website"]))
								<a
									href="{{ $data['socials']['personal_website'] }}"
									target="_blank"
									rel="noopener noreferrer"
									class="text-gray-400 transition-colors hover:text-white"
								>
									<span class="sr-only">Website</span>
									<svg
										xmlns="http://www.w3.org/2000/svg"
										class="h-6 w-6"
										fill="none"
										viewBox="0 0 24 24"
										stroke="currentColor"
										stroke-width="2"
									>
										<path
											stroke-linecap="round"
											stroke-linejoin="round"
											d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"
										/>
									</svg>
								</a>
							@endif
						</div>

						@if (!empty($data["skills"]))
							<div class="border-t border-gray-800 pt-6">
								<h3
									class="text-sm font-semibold uppercase tracking-wider text-gray-400"
								>
									Core Toolkit
								</h3>
								<div class="mt-4 flex flex-wrap gap-2">
									@foreach ($data["skills"] as $skill)
										<span
											class="inline-flex items-center rounded-full bg-gray-800 px-3 py-1 text-sm font-medium text-emerald-400"
										>
											{{ $skill }}
										</span>
									@endforeach
								</div>
							</div>
						@endif

						<div class="border-t border-gray-800 pt-6">
							<h3
								class="text-sm font-semibold uppercase tracking-wider text-gray-400"
							>
								Contact
							</h3>
							<a
								href="mailto:{{ $data['email'] }}"
								class="mt-2 block text-emerald-400 transition-colors hover:text-emerald-300"
								>{{ $data["email"] }}</a
							>
						</div>
					</div>
				</aside>

				<section class="lg:col-span-2 space-y-12">
					<!-- Projects Section -->
					<div>
						<h3 class="mb-6 text-2xl font-bold text-white">
							Featured Projects
						</h3>
						<div class="grid grid-cols-1 gap-8">
							@forelse($data['projects'] as $project)
								<div
									class="group relative rounded-lg border border-gray-800 bg-gray-800/50 p-6 transition-all hover:border-emerald-500/30 hover:bg-gray-800"
								>
									<h4 class="text-xl font-bold text-white">
										{{ $project["title"] }}
									</h4>
									@if (isset($project["description"]) && $project["description"])
										<p class="mt-2 text-gray-400">
											{{ $project["description"] }}
										</p>
									@endif
									@if (isset($project["url"]) && $project["url"])
										<a
											href="{{ $project['url'] }}"
											target="_blank"
											rel="noopener noreferrer"
											class="mt-4 inline-flex items-center text-sm font-semibold text-emerald-400 hover:text-emerald-300"
										>
											View Project
											<svg
												xmlns="http://www.w3.org/2000/svg"
												class="ml-1 h-4 w-4"
												fill="none"
												viewBox="0 0 24 24"
												stroke="currentColor"
												stroke-width="2"
											>
												<path
													stroke-linecap="round"
													stroke-linejoin="round"
													d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
												/>
											</svg>
											<span class="absolute inset-0"></span>
										</a>
									@endif
								</div>
							@empty
								<div
									class="rounded-lg border border-gray-800 bg-gray-800/50 p-6"
								>
									<p class="text-gray-400">No projects to display yet.</p>
								</div>
							@endforelse
						</div>
					</div>

					<!-- Experience Section -->
					@if (!empty($data['experiences']))
						<div>
							<h3 class="mb-6 text-2xl font-bold text-white">
								Experience
							</h3>
							<div class="space-y-8">
								@foreach($data['experiences'] as $experience)
									<div class="relative border-l-2 border-emerald-500 pl-6">
										<div class="absolute -left-2 top-0 h-4 w-4 rounded-full bg-emerald-500"></div>
										<div class="rounded-lg border border-gray-800 bg-gray-800/50 p-6">
											<h4 class="text-xl font-bold text-white">
												{{ $experience["title"] }}
											</h4>
											<p class="text-emerald-400 font-medium">
												{{ $experience["company"] }}
												@if (isset($experience["location"]) && $experience["location"])
													<span class="text-gray-400"> • {{ $experience["location"] }}</span>
												@endif
											</p>
											@if (isset($experience["start_date"]) || isset($experience["end_date"]))
												<p class="text-sm text-gray-500 mt-1">
													@if (isset($experience["start_date"]) && $experience["start_date"] && $experience["start_date"] !== "0001-03-31" && !str_starts_with($experience["start_date"], "4567"))
														{{ date('M Y', strtotime($experience["start_date"])) }}
													@endif
													@if (isset($experience["end_date"]) && $experience["end_date"] && $experience["end_date"] !== "1212-12-26" && !str_starts_with($experience["end_date"], "4567"))
														@if (isset($experience["start_date"]) && $experience["start_date"] && $experience["start_date"] !== "0001-03-31" && !str_starts_with($experience["start_date"], "4567"))
															- {{ date('M Y', strtotime($experience["end_date"])) }}
														@else
															{{ date('M Y', strtotime($experience["end_date"])) }}
														@endif
													@elseif (isset($experience["start_date"]) && $experience["start_date"] && $experience["start_date"] !== "0001-03-31" && !str_starts_with($experience["start_date"], "4567"))
														- Present
													@endif
												</p>
											@endif
											@if (isset($experience["description"]) && $experience["description"])
												<p class="mt-3 text-gray-400">
													{{ $experience["description"] }}
												</p>
											@endif
										</div>
									</div>
								@endforeach
							</div>
						</div>
					@endif

					<!-- Education Section -->
					@if (!empty($data['education']))
						<div>
							<h3 class="mb-6 text-2xl font-bold text-white">
								Education
							</h3>
							<div class="space-y-8">
								@foreach($data['education'] as $education)
									<div class="relative border-l-2 border-blue-500 pl-6">
										<div class="absolute -left-2 top-0 h-4 w-4 rounded-full bg-blue-500"></div>
										<div class="rounded-lg border border-gray-800 bg-gray-800/50 p-6">
											<h4 class="text-xl font-bold text-white">
												{{ $education["degree"] }}
												@if (isset($education["field_of_study"]) && $education["field_of_study"] && $education["field_of_study"] !== "school")
													<span class="text-gray-300"> in {{ $education["field_of_study"] }}</span>
												@endif
											</h4>
											<p class="text-blue-400 font-medium">
												{{ $education["school"] }}
											</p>
											@if (isset($education["start_date"]) || isset($education["end_date"]))
												<p class="text-sm text-gray-500 mt-1">
													@if (isset($education["start_date"]) && $education["start_date"] && $education["start_date"] !== "0001-03-31" && !str_starts_with($education["start_date"], "4567"))
														{{ date('M Y', strtotime($education["start_date"])) }}
													@endif
													@if (isset($education["end_date"]) && $education["end_date"] && $education["end_date"] !== "1212-12-26" && !str_starts_with($education["end_date"], "4567"))
														@if (isset($education["start_date"]) && $education["start_date"] && $education["start_date"] !== "0001-03-31" && !str_starts_with($education["start_date"], "4567"))
															- {{ date('M Y', strtotime($education["end_date"])) }}
														@else
															{{ date('M Y', strtotime($education["end_date"])) }}
														@endif
													@elseif (isset($education["start_date"]) && $education["start_date"] && $education["start_date"] !== "0001-03-31" && !str_starts_with($education["start_date"], "4567"))
														- Present
													@endif
												</p>
											@endif
											@if (isset($education["description"]) && $education["description"])
												<p class="mt-3 text-gray-400">
													{{ $education["description"] }}
												</p>
											@endif
										</div>
									</div>
								@endforeach
							</div>
						</div>
					@endif
				</section>
			</main>

			<footer class="mt-16 text-center text-xs text-gray-500">
				<p>
					Powered by
					<a
						href="https://getmy.name"
						target="_blank"
						rel="noopener noreferrer"
						class="transition-colors hover:text-emerald-400"
						>getmy.name</a
					>
					from
					<a
						href="https://mtex.dev"
						target="_blank"
						rel="noopener noreferrer"
						class="transition-colors hover:text-emerald-400"
						>mtex.dev</a
					>
				</p>
			</footer>
		</div>
	</body>
</html>