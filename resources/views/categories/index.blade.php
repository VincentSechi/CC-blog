@extends('layouts.app')

@section('title', 'Liste des catégories')

@section('content')
    <section class="heading">
        <h1 class="title">
            Liste des catégories
        </h1>
    </section>
    <section class="container">
        <section class="categories-container">
                    @foreach ($categories as $category)
                    <div class="article-category">
                        <p class="category"><a href="{{ route('articles.filterByCategory', $category->name) }}">{{ $category->name }}</a>
                        </p>
                    </div>
                    @endforeach
        </section>
    </section>
@endsection
