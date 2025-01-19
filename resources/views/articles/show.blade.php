@extends('layouts.app')

@section('title', $article->title)

<?php

$dateTime = new DateTime($article->created_at);

$format = 'l d F Y';
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
$date = strftime('%A %d %B %Y', $dateTime->getTimestamp());
?>
@section('content')
    <section class="container">
        <section class="article-container">
            <div class="heading">
                <h1 class="title">
                    {{ $article->title }}
                </h1>
                <div class="article-info">
                    <p>Ecrit par
                        <span class="author">
                            {{ $article->author }}
                        </span>
                        le <span class="date">{{ $date }}</span>
                    </p>
                </div>
            </div>
            <div class="manage-article">
                <a class="edit-article" href="{{ route('articles.edit', $article->id) }}">Modifier</a>
                <form action="{{ route('articles.destroy', $article->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="delete-article" type="submit"
                        onclick="return(confirm('Etes vous sûr ?'))">Supprimer</button>
                </form>
            </div>
            <div class="article-content">
                <div class="article-category">
                    <span class="category">
                        {{ $article->category->name }}
                    </span>
                </div>
                <div class="content">
                    <div class="image-container">
                        <img src="{{ Storage::url($article->photo) }}" alt="photo">
                    </div>
                    <p>
                        {{ $article->content }}
                    </p>
                </div>
            </div>
        </section>
        <section class="comments-container">
            <div class="all-comments">
                <h2>Commentaires</h2>

                @if ($article->comments->isEmpty())
                    <p>Aucun commentaire pour le moment.</p>
                @else
                    @foreach ($article->comments as $comment)
                        <div class="comment">
                            <h4>{{ $comment->first_name }} {{ $comment->last_name }}</h4>
                            <p>{{ $comment->message }}</p>
                            <small>Posté le {{ $comment->created_at->format('d/m/Y à H:i') }}</small>
                        </div>
                        <hr>
                    @endforeach
                @endif
            </div>
            <div class="create-comment">
                <h2>Écrire un commentaire</h2>
                <form action="{{ route('comments.store', $article->id) }}" method="POST">
                    @csrf
                    <div>
                        <label for="first_name">Prénom :</label>
                        <input type="text" id="first_name" name="first_name" required>
                    </div>
                    <div>
                        <label for="last_name">Nom :</label>
                        <input type="text" id="last_name" name="last_name" required>
                    </div>
                    <div>
                        <label for="email">Email :</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div>
                        <label for="message">Message :</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    <button type="submit">Envoyer</button>
                </form>
            </div>
        </section>
    </section>

@endsection
