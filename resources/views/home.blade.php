<x-layout>
    {{-- Hero Start --}}
    <section class="mt-auto w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="flex flex-col lg:flex-row justify-center items-center gap-24 py-12 lg:py-24">
            <div class="flex flex-col gap-6 justify-center w-auto lg:w-[860px] items-start">
                <h1 class="text-3xl lg:text-4xl font-bold">
                    Menyajikan Fakta, Menginspirasi Perubahan
                </h1>
                <p class="text-base font-medium">
                    Selamat datang di NewsWave, sumber informasi terpercaya yang mengutamakan kecepatan dan akurasi. 
                    Dapatkan berita terbaru dari berbagai belahan dunia, mulai dari politik, ekonomi, hingga gaya hidup, 
                    semuanya ada di sini. Kami hadir untuk memberikan wawasan mendalam dan perspektif yang menginspirasi, 
                    karena setiap berita adalah langkah menuju perubahan.
                </p>
                <a href="#" class="text-base px-8 py-3 bg-[#FE6716] rounded-2xl font-medium text-white">
                    Explore Now
                </a>
            </div>
            <img src="{{ asset('storage/HeroImg.png') }}" alt="" class="size-72 lg:size-[580px]">
        </div>
    </section>
    {{-- Hero End --}}
    {{-- Lastest News Start --}}
    <div class="bg-[#10101C] text-white">
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
                            <img class="w-auto h-auto lg:w-[400px] lg:h-[225px] object-cover" src="{{ asset('storage/' . $news->image_url) }}" alt="News Image">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-white">
                                {{ \Illuminate\Support\Str::limit($news->title, 50, '...') }}
                            </h3>
                            <p class="text-sm text-neutral-300 mb-4">
                                {{ \Illuminate\Support\Str::words(strip_tags($news->content, '<b>'), 18, '...') }}
                            </p>
                            <div class="flex items-center text-sm text-neutral-100">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $news->user->name }} - {{ $news->created_at->format('d M Y') }}
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    {{-- Lastest News End --}}
    {{-- Populer News Carousel Start --}}
    <section class="mt-auto w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="flex flex-col justify-center gap-16 py-10 lg:py-16">
            <div class="flex flex-col gap-4 items-start">
                <h1 class="text-3xl lg:text-4xl font-bold text-[#FE6716]">
                    Populer News
                </h1>
            </div>
            <div class="flex justify-center items-center">
                <button id="prevBtn" class="px-1 py-1 lg:px-3 lg:py-3 bg-[#FE6716] text-white font-bold rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="ww-3 h-3 lg:w-6 lg:h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <!-- Carousel container -->
                <div id="carousel" class="relative overflow-hidden rounded-lg shadow-lg w-full sm:w-3/4">
                    <!-- Slides -->
                    <div class="flex transition-transform duration-300 ease-in-out">
                        @foreach ($mostLikedNews as $news)
                        <!-- Slide 1 -->
                        <a href="/news/{{ $news->slug }}" class="w-full sm:w-1/2 flex-shrink-0 p-2 group">
                            <div class="relative rounded-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $news->image_url) }}" alt="House" class="w-auto h-auto lg:w-[470px] lg:h-[294px] object-cover">
                                <div class="hidden flex-col group-hover:flex absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black to-transparent">
                                    <h2 class="text-white text-lg font-bold">
                                        {{ \Illuminate\Support\Str::limit($news->title, 50, '...') }}
                                    </h2>
                                    <p class="text-gray-200 text-xs mt-1">
                                        {{ \Illuminate\Support\Str::words(strip_tags($news->content, '<b>'), 21, '...') }}
                                    </p>
                                    <div class="flex items-center mt-2">
                                        <div class="w-6 h-6 rounded-full bg-gray-300 mr-2"></div>
                                        <div>
                                            <p class="text-white text-xs font-semibold">
                                                {{ $news->user->name }}
                                            </p>
                                            <p class="text-gray-300 text-xs">
                                                {{ $news->created_at->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                <button id="nextBtn" class="px-1 py-1 lg:px-3 lg:py-3 bg-[#FE6716] text-white font-bold rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-3 h-3 lg:w-6 lg:h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>            
        </div>
    </section>
    {{-- Populer News Carousel End --}}
    {{-- Category Start --}}
    <div class="bg-[#10101C] text-white">
        <section class="mt-auto w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
            <div class="flex flex-col justify-center gap-16 py-10 lg:py-16">
                <div class="flex flex-col gap-4 items-center">
                    <h1 class="text-3xl lg:text-4xl font-bold text-[#FE6716]">
                        Category
                    </h1>
                    <p class="text-base font-medium w-auto text-center">
                        Silahkan mencari berita sesuai kategori yang anda inginkan.
                    </p>
                </div>
                <div class="flex flex-wrap justify-center items-center gap-6 lg:gap-11">
                    @foreach ( $categories as $item )
                    <a href="/category/{{ $item->slug }}" class="flex flex-col justify-center items-center gap-3 group">
                        <img src="https://via.placeholder.com/400x225" alt="" class="w-24 h-24 lg:w-40 lg:h-40 rounded-lg">
                        <span class="text-2xl lg:text-3xl font-bold group-hover:text-[#FE6716]">{{ $item->name }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    {{-- Category End --}}
    {{-- Daftar Penulis Start --}}
    <div class="bg-[#000038] text-white">
        <section class="mt-auto w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
            <div class="flex flex-col lg:flex-row justify-center items-start lg:items-center gap-6 lg:gap-24 py-10 lg:py-16">
                <div class="flex flex-col gap-4 w-auto lg:w-[364px]">
                    <div class="border-4 border-[#FE6716]"></div>
                    <h2 class="text-xl font-bold w-[342px]">
                        Ingin Menjadi Penulis agar berita anda dapat diterbitkan?
                    </h2>
                </div>
                <p class="text-base font-semibold w-auto lg:w-[524px]">
                    Pellentesque tristique ac dui vel convallis. 
                    Nunc interdum enim sit amet blandit tincidunt.
                </p>
                <a href="#" class="px-8 py-3 bg-[#FE6716] rounded-xl">
                    Sign Up
                </a>
            </div>
        </section>
    </div>
    {{-- Daftar Penulis End --}}
</x-layout>

<script>
    const carousel = document.getElementById('carousel');
    const slides = carousel.querySelector('div');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    let currentIndex = 0;
    let slideWidth = carousel.clientWidth;

    window.addEventListener('resize', () => {
        slideWidth = carousel.clientWidth;
        showSlide(currentIndex);
    });

    function showSlide(index) {
        slides.style.transform = `translateX(-${index * slideWidth}px)`;
    }

    prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            showSlide(currentIndex);
        }
    });

    nextBtn.addEventListener('click', () => {
        if (currentIndex < slides.children.length - 1) {
            currentIndex++;
            showSlide(currentIndex);
        }
    });
</script>