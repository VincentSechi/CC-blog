@extends('layouts.app')

@section('title', 'Liste des articles')


@section('content')
    <section class="heading">
        <h1 class="title">
            Liste des articles
        </h1>
    </section>
    <section class="category-container">
        <div class="category-heading">
            <p>Filtrer par :</p>
        </div>
        @if (isset($categories))
            @foreach ($categories as $category)
                <div class="article-category"><a href="{{ route('articles.filterByCategory', $category->name) }}"
                        class="category">{{ $category->name }}</a>
                </div>
            @endforeach
        @endif
    </section>
    <section class="container">
        <section class="search-bar">
            <form action="{{ route('articles.index') }}" method="GET" class="search-form">
                <input type="text" name="q" placeholder="Rechercher un article..." value="{{ request('q') }}"
                    class="search-input">
                <button type="submit" class="search-button">Rechercher</button>
            </form>
        </section>
        <section class="articles-container">
            @foreach ($articles as $article)
                <?php
                $dateTime = new DateTime($article->created_at);
                $format = 'l d F Y';
                setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
                $date = strftime('%A %d %B %Y', $dateTime->getTimestamp());
                ?>
                <a href="{{ route('articles.show', $article->id) }}" class="article-container">
                    <div class="article-wrapper">
                        <div class="article-heading">
                            <div class="article-heading-wrapper">
                                <h2>{{ $article->title }}</h2>
                                <p>{{ $article->excerpt }}</p>
                                <span>Publié le {{ $date }}</span>
                            </div>
                        </div>
                        <div class="article-category">
                            <span class="category">
                                {{ $article->category->name }}
                            </span>
                        </div>
                        <div class="image-container">
                            @if (!empty($article->photo))
                                <img src={{ Storage::url($article->photo) }}>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </section>
        <div class="pagination-container">
        {{ $articles->links() }}
        </div>
    </section>
@endsection
