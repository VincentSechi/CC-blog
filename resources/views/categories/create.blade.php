@extends('layouts.app')

@section('title', 'Ajouter une catégorie')

@section('content')
    <section class="heading">
        <h1 class="title">
            Créer une catégorie
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
            <form action="{{ route('categories.store') }}" method="POST" class="category-form">
                @csrf
                <div class="form-container">
                    <div class="input-field">
                        <label for="name">Nom</label>
                        <input type="text" name="name" id="name" value="">
                    </div>
                    <div class="input-field" style="margin-top:20px;">
                        <label for="description">Description</label>
                        <textarea type="text" name="description" id="description" value="">
                        </textarea>
                    </div>
                </div>
                <button class="button-form" type="submit" style="margin-top:40px;">Envoyer</button>
            </form>
        </div>
    </section>
@endsection
