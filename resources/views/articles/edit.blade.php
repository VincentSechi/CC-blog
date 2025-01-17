@extends('layouts.app')

@section('title', 'Modifier un article')

@section('content')
    <section class="heading">
        <h1 class="title">
            Modifier un article
        </h1>
        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif
        @if ($errors->any())
            <div class="error-container">
                @foreach ($errors->all() as $error)
                    <p class="error">{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </section>
    <section class="container">
        <div class="wrapper">
            <form action="{{ route('articles.update', $article->id) }}" method="POST" class="article-form" enctype="multipart/form-data">
                @csrf
                <div class="form-container">
                    <div class="input-block">
                        <div class="input-fields">
                            <div class="input-field">
                                <label for="title">Titre</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}">
                            </div>
                            <div class="input-field">
                                <label for="author">Auteur</label>
                                <input type="text" name="author" id="author" value="{{ old('author', $article->author) }}">
                            </div>
                            <div class="select-field">
                                <label for="category_id">Catégorie</label>
                                <select name="category_id" id="category_id" class="select">
                                    <option value="" disabled>Choisir</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="select-photo">
                            <label for="photo">Choisir une image</label>
                            <input type="file" name="photo" id="photo" class="input-file"
                                style="position: absolute; width: 100%; height:100%; opacity:0; z-index:10; display:flex; cursor:pointer;">
                            <img id="preview" src={{ asset('icons/download-solid.svg') }} class="download-icon">
                        </div>
                    </div>
                    <div class="wysiwyg-field" style="margin-top:20px;">
                        <label for="content">Contenu</label>
                        <textarea rows="10" type="text" name="content" id="content" value=""></textarea>
                    </div>

                </div>
                <button class="button-form" type="submit" style="margin-top:40px;">Envoyer</button>
            </form>
        </div>
    </section>

    <script>
        document.getElementById('photo').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        });
    </script>

@endsection
