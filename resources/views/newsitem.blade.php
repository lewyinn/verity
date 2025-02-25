<x-layout>
    <section class="mt-auto w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="flex flex-col justify-center gap-4 py-12 lg:py-24">
            <div class="flex flex-col justify-center gap-3">
                <div class="flex justify-start items-start">
                    <h1 class="text-2xl lg:text-4xl font-bold">
                        {{ $newsOne->category ? $newsOne->category->name : 'Uncategorized' }}
                    </h1>
                </div>
                <div class="flex flex-col justify-center items-center gap-2">
                    <img src="{{ asset('storage/' . $newsOne->image_url) }}" alt="" class="w-auto lg:w-[1080px] h-auto lg:h-[460px] object-cover object-top rounded-2xl">
                    <div class="flex justify-end items-end gap-2">
                        <div class="flex justify-center items-center gap-1">
                            <svg 
                                xmlns="http://www.w3.org/2000/svg" 
                                viewBox="0 0 512 512" 
                                class="w-6 h-6 cursor-pointer" 
                                id="like-icon-{{ $newsOne->id }}"
                                @if ($newsOne->isLikedByUser(auth()->id())) 
                                    fill="red" 
                                    stroke="none" 
                                @else 
                                    fill="none" 
                                    stroke="black" 
                                    stroke-width="32" 
                                @endif
                                onclick="toggleLike({{ $newsOne->id }})">
                                <path d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z"/>
                            </svg>
                            <p class="text-lg font-medium" id="likes-count-{{ $newsOne->id }}">
                                {{ $newsOne->likes_count }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col justify-start items-start gap-1">
                    <h1 class="text-2xl lg:text-3xl font-bold ">
                        {{ $newsOne->title }}
                    </h1>
                    <p class="text-lg lg:text-xl font-medium">
                        Author By {{ $newsOne->user->name }}
                    </p>
                    <p class="text-lg lg:text-xl font-normal">
                        {{ $newsOne->created_at->format('d M Y') }}
                    </p>
                </div>
                <span class="border border-black"></span>
                <div class="flex flex-col justify-start items-start">
                    <p class="news-content">
                        {!! str_replace('<a', '<a style="text-decoration: underline;"', $newsOne->content) !!}
                    </p>
                </div>
                <span class="border border-black"></span>
                <div class="flex flex-col justify-start items-start gap-3">
                    @foreach($newsOne->comments as $comment)
                        <div class="flex flex-col justify-start items-start gap-2 bg-white p-3 shadow rounded-lg mt-2">
                            <div class="flex justify-start items-center gap-4">
                                <img src="{{ $comment->user->avatar_url ?? 'https://placeholder.com/100x100' }}" alt="" class="w-9 h-9 object-cover rounded-full">
                                <h1 class="text-lg font-semibold">{{ $comment->user->name }}</h1>
                                <p class="text-base font-medium">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                            <div>
                                <p class="text-base font-normal">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @endforeach
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="news_id" value="{{ $newsOne->id }}">
                        <div class="flex flex-col justify-start items-start p-6">
                            <label for="comment" class="block text-gray-700 text-2xl font-bold mb-2">Leave A Comment</label>
                            <textarea id="comment" name="content" placeholder="Your Comment" cols="210" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
                            <button type="submit" class="mt-4 px-6 py-2 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
    </section>
</x-layout>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function toggleLike(newsId) {
        axios.post('/news/' + newsId + '/toggle-like')
            .then(response => {
                // Update the likes count and heart icon
                let likesCountElem = document.getElementById('likes-count-' + newsId);
                let likeIconElem = document.getElementById('like-icon-' + newsId);
                
                likesCountElem.innerText = response.data.likes_count;

                // Update the heart icon fill color
                if (response.data.liked) {
                    likeIconElem.setAttribute('fill', 'red');
                } else {
                    likeIconElem.setAttribute('fill', 'none');
                }
            })
            .catch(error => {
                console.log('Error toggling like:', error);
            });
    }
</script>