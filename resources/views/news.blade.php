<x-layout>
    <div class="bg-[#10101C] text-white">
        <section class="mt-auto w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
            <div class="flex flex-col justify-center items-center gap-3 py-16 lg:py-24">
                <h1 class="text-2xl lg:text-4xl text-[#FE6716] font-bold">
                    Welcome to Verity
                </h1>
                <div>
                    <p class="text-xl lg:text-3xl font-semibold text-center w-auto lg:w-[762px]">
                        <span class="text-[#FE6716]">Versity</span> 🎉 Portal berita <span
                            class="text-[#FE6716]">modern</span> dengan update
                        <span class="text-[#FE6716]">cepat</span>, <span class="text-[#FE6716]">akurat</span>, dan <span
                            class="text-[#FE6716]">terpercaya</span>. 🔥
                    </p>
                </div>
            </div>
        </section>
    </div>
    <section class="mt-auto w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
        @foreach ($mostLikedNews1 as $news )
        <a href="/news/{{ $news->slug }}" class="flex flex-col lg:flex-row justify-center items-center gap-8 lg:gap-20 py-10 lg:py-24">
            <img src="{{ asset('storage/' . $news->image_url) }}" alt=""
                class="w-auto lg:w-[480px] h-auto lg:h-[320px] rounded-2xl object-cover">
            <div class="flex flex-col justify-between gap-7 w-auto lg:w-[554px]">
                <div class="flex justify-start items-center gap-2">
                    <img src="{{ asset($news->user->avatar_url ? 'storage/' . $news->user->avatar_url : 'https://w7.pngwing.com/pngs/339/876/png-transparent-login-computer-icons-password-login-black-symbol-subscription-business-model-thumbnail.png') }}" 
                    alt="" class="w-12 h-12 rounded-full">
                    <p class="text-xl font-semibold">
                        <span class="text-[#FE6716] font-bold">
                            {{ $news->user->name }}
                        </span> - {{ $news->created_at->format('d M Y') }}
                    </p>
                </div>
                <h1 class="text-xl lg:text-3xl font-bold">
                    {{ \Illuminate\Support\Str::limit($news->title, 50, '...') }}
                </h1>
                <p class="text-base lg:text-lg font-medium">
                    {{ \Illuminate\Support\Str::words(strip_tags($news->content, '<b>'), 48, '...') }}
                </p>
                <p class="text-xl font-medium">
                    <span class="text-[#FFC107]">
                        {{ $news->category->name }}
                    -</span> <span class="text-[#FF0000]">
                        {{ $news->likes_count }} Likes
                    </span>
                </p>
            </div>
        </a>
        @endforeach
    </section>
    <section class="mt-auto w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="flex flex-col justify-center items-center gap-16 py-10 lg:py-16">
            <div class="flex flex-col justify-center gap-4 items-center">
                <h1 class="text-2xl lg:text-4xl font-bold text-[#FE6716]">
                    Lastest News
                </h1>
                <p class="text-base font-medium w-auto lg:w-[524px] text-center">
                    Temukan berita terbaru dari berbagai topik, mulai dari politik,
                    teknologi, hingga peristiwa dunia, semuanya disajikan up-to-date
                    dan terpercaya.
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-14">
                @foreach ($latestNews as $news)
                <a href="/news/{{ $news->slug }}" class="bg-transparent rounded-lg shadow-sm overflow-hidden">
                    <div class="aspect-w-16 aspect-h-9">
                        <img class="w-auto h-auto lg:w-[400px] lg:h-[225px] object-cover" src="{{ asset('storage/' . $news->image_url) }}"
                            alt="News Image">
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-black">
                            {{ \Illuminate\Support\Str::limit($news->title, 50, '...') }}
                        </h3>
                        <p class="text-sm text-neutral-800 mb-4">
                            {{ \Illuminate\Support\Str::words(strip_tags($news->content, '<b>'), 18, '...') }}
                        </p>
                        <div class="flex items-center text-sm text-neutral-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ $news->user->name }} - {{ $news->created_at->format('d M Y') }}
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    <div class="bg-[#10101C] text-white">
        <section class="mt-auto w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
            <div class="flex flex-col justify-center gap-9 py-7 lg:py-14">
                <div class="flex justify-center items-center lg:justify-start lg:items-start">
                    <h1 class="text-xl lg:text-3xl font-bold text-[#FE6716]">
                        Top Authors
                    </h1>
                </div>
                <div class="flex flex-col lg:flex-row justify-center items-center gap-12">
                    @foreach ($topWriters as $user)
                    <div class="flex justify-center items-center gap-4">
                        <img src="{{ asset($user->avatar_url ? 'storage/' . $user->avatar_url : 'https://w7.pngwing.com/pngs/339/876/png-transparent-login-computer-icons-password-login-black-symbol-subscription-business-model-thumbnail.png') }}" 
                            alt="" class="w-20 h-20 rounded-full">
                        <div class="flex flex-col justify-start items-start gap-2">
                            <h2 class="text-xl lg:text-2xl font-bold">
                                {{ $user->name }}
                            </h2>
                            <p class="text-base lg:text-lg font-medium text-[#FE6716]">
                                {{ $user->news_count }} News
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    <section class="mt-auto w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="flex flex-col justify-center gap-16 py-10 lg:py-16">
            <div class="flex flex-col justify-start gap-4 items-start">
                <h1 class="text-2xl lg:text-4xl font-bold text-[#FE6716]">
                    Recomended News
                </h1>
                <p class="text-base font-medium text-center">
                    Berikut adalah berita yang direkomendasikan acak oleh AI
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-14">
                @foreach ($randomNews as $news)
                <a href="/news/{{ $news->slug }}" class="bg-transparent rounded-lg shadow-sm overflow-hidden">
                    <div class="aspect-w-16 aspect-h-9">
                        <img class="w-auto h-auto lg:w-[400px] lg:h-[225px] object-cover" src="{{ asset('storage/' . $news->image_url) }}"
                            alt="News Image">
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-black">
                            {{ \Illuminate\Support\Str::limit($news->title, 50, '...') }}
                        </h3>
                        <p class="text-sm text-neutral-800 mb-4">
                            {{ \Illuminate\Support\Str::words(strip_tags($news->content, '<b>'), 18, '...') }}
                        </p>
                        <div class="flex items-center text-sm text-neutral-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ $news->user->name }} - {{ $news->created_at->format('d M Y') }}
                        </div>
                    </div>
                </a>
                @endforeach 
            </div>
        </div>
    </section>
</x-layout>