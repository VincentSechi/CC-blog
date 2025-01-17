<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- On appelle la section title créée dans les vues -->
    <title>@yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>

    <nav class="navbar">
        <div class="navbar-wrapper">
            <a href="{{ url('/articles') }}" class="navbar-logo">
                <img src="{{ asset('images/tml.jpg') }}" alt="" class="logo">
            </a>
            <ul class="links">
                <li class="link">
                    <a href="{{ route('articles.create') }}" class="link-item">
                        Publier un article
                    </a>
                </li>
                {{-- <li class="link">
                    <a href="{{ route('categories.index') }}" class="link-item">
                        Voir les catégories
                    </a>
                </li> --}}
                <li class="link">
                    <a href="{{ route('categories.create') }}" class="link-item">
                        Ajouter une catégorie
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="">
        <!-- On appelle la section content créée dans les vues -->
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-container">
            <p>&copy 2025 - TML</p>
        </div>
    </footer>
</body>

</html>
