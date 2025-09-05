<section class="overflow-hidden py-24 sm:py-32 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-2 lg:items-start">
            <div class="lg:pr-8 lg:pt-4">
                <div class="lg:max-w-lg">
                    <h2 class="text-base font-semibold leading-7 text-indigo-600 dark:text-indigo-400">
                        {{ __('lander.api_showcase.section_title') }}
                    </h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-4xl">
                        {{ __('lander.api_showcase.title') }}
                    </p>
                    <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-400">
                        {{ __('lander.api_showcase.description') }}
                    </p>
                    <div class="mt-10 max-w-xl text-base leading-7 text-gray-700 dark:text-gray-300 lg:max-w-none">
                        <p>
                            {{ __('lander.api_showcase.info_paragraph_1') }}
                        </p>
                        <p class="mt-8">
                            {{ __('lander.api_showcase.info_paragraph_2') }}
                        </p>
                        <div class="flex items-center mt-6 gap-x-6">
                            <a href="#get-started"
                               class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors duration-200">
                                {{ __('lander.api_showcase.cta_btn') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center -m-4 lg:-m-8">
                <div class="w-full max-w-lg rounded-xl bg-gray-900 dark:bg-gray-800 p-6 shadow-xl ring-1 ring-gray-400/10 dark:ring-gray-700/20 lg:max-w-none lg:w-[36rem]">
                    <div class="flex items-center space-x-2">
                        <div class="h-3 w-3 rounded-full bg-red-500"></div>
                        <div class="h-3 w-3 rounded-full bg-yellow-400"></div>
                        <div class="h-3 w-3 rounded-full bg-green-500"></div>
                    </div>
                    <pre class="mt-4 text-xs overflow-x-auto overflow-y-auto max-h-[30rem] text-gray-200 dark:text-gray-300">
<code class="language-json">{
  "name": "Jane Doe",
  "username": "janedoe",
  "title": "Senior Laravel Developer",
  "bio": "Experienced developer focused on building scalable web applications.",
  "location": "Berlin, Germany",
  "avatar_url": "http://getmy-name.test/storage/avatars/avatar-hash.png",
  "email": "jane@example.com",
  "about_me": "I am a passionate Laravel developer with over 10 years of experience in building robust and scalable web applications. My expertise spans across the full development lifecycle, from conceptualization and design to deployment and maintenance. I enjoy working with modern technologies and continuously strive to learn and implement best practices in software development. In my free time, I contribute to open-source projects and mentor junior developers. I believe in clean code, automated testing, and continuous integration to deliver high-quality solutions.",
  "skills": [
    "PHP", "JavaScript", "Laravel", "Vue.js", "Docker"
  ],
  "projects": [
    {
      "id": "0198fa05-a6e5-70dd-858c-ba511b4652d9",
      "title": "E-commerce Platform",
      "name": "E-commerce Platform",
      "description": "Built a scalable e-commerce solution...",
      "url": "https://example.com/ecommerce",
      "image_path": "http://getmy-name.test/storage/projects/project-image-uuid-1.png"
    }
  ],
  "experiences": [
    {
      "id": "0198ff8c-47a7-73f5-a88e-8bc2428c746e",
      "title": "Lead Developer",
      "company": "Tech Solutions Inc.",
      "location": "Berlin",
      "start_date": "2018-01-01",
      "end_date": "2023-12-31",
      "description": "Led a team of developers in building and maintaining enterprise applications."
    }
  ],
  "education": [
    {
      "id": "019905e5-081e-737c-af91-abd4c58f957d",
      "school": "University of Technology",
      "degree": "Master of Computer Science",
      "field_of_study": "Software Engineering",
      "start_date": "2013-09-01",
      "end_date": "2017-07-15",
      "description": "Graduated with honors, specialized in distributed systems."
    }
  ],
  "socials": {
    "github": "janedoe-gh",
    "linkedin": "janedoe-li",
    "twitter": "janedoe_tweets",
    "personal_website": "https://janedoe.com"
  },
  "api_request_count": 123
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>