@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
      <button class="post-subcategory">
        @foreach($post->subcategories as $subcategory)
          {{$subcategory->sub_category}}
        @endforeach
      </button>
      <div class="post_bottom_area d-flex">
        <div class="d-flex post_status">
          <div class="mr-5">
            <i class="fa fa-comment button-comment"></i><span class="comment-count">{{$post->postComments()->count()}}</span>
          </div>
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{$post->id}} like-count">{{$like->likeCounts($post->id)}}</span></p>
            @else
            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{$post->id}} like-count">{{$like->likeCounts($post->id)}}</span></p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area border w-25">
    <div class="border m-4">
    <form action="{{ route('post.show') }}" method="get" id="postSearchRequest">
      <div class="post-create">
        <a href="{{ route('post.input') }}">投稿</a>
      </div>
      <div class="post-search">
        <span>検索</span>
        <input type="text" class="search-image-text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="image" class="search-images" src="../images/検索窓.png" alt="検索ボタン" form="postSearchRequest">
      </div>
      <input type="submit" name="like_posts" class="category_btn_like" value="いいねした投稿" form="postSearchRequest">
      <input type="submit" name="my_posts" class="category_btn_mine" value="自分の投稿" form="postSearchRequest">
      <sopan class="category-span">カテゴリー</span>
      <ul>
        @foreach($main_categories as $main_category)
        <div class="accordion js-accordion">
          <span class="main_categories">{{ $main_category->main_category }}</span>
        </div>
        <div class="subcategories">
        @foreach($main_category->subCategories as $subCategory)
          <li>
            <input type="submit" name="sub_posts" value="{{$subCategory->sub_category}}" form="postSearchRequest">
          </li>
        @endforeach
        </div>
        @endforeach
      </ul>
    </div>
  </div>
</form>
</div>
@endsection