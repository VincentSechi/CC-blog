<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = $request->input('q');

    // Rechercher les articles en fonction du titre, du contenu ou de l'auteur
    $articles = Article::with('category')
        ->when($query, function ($queryBuilder) use ($query) {
            $queryBuilder->where('title', 'LIKE', "%{$query}%")
                ->orWhere('content', 'LIKE', "%{$query}%")
                ->orWhere('author', 'LIKE', "%{$query}%");
        })
        ->orderBy('created_at', 'desc')->paginate(3);
    // Retourner la vue avec les articles filtrés et le terme de recherche
    return view('articles.index', [
        'articles' => $articles,
        'query' => $query,
        'categories' => $categories,
    ]);
    }
    public function create()
    {
        $categories = Category::all(); // pour mettre les services dans un select option
        return view('articles.create', ['categories' => $categories]);
    }

    public function show(Article $article)
    {
        $categories = Category::all();

        return view('articles.show', [
            'article' => $article,
            'categories' => $categories,
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'author'        => 'string|max:255',
            'category_id'   => 'nullable|exists:categories,id',
            'content'         => 'required|string|max:255',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = $path;
        }

        Article::create($validated);

        return back()->with('success', 'Nouvel article enregistré');
    }
    public function edit (Article $article) 
    {
        // tous les champs sauf la photo sont pré remplis par les informations de l'employé
        // On récupère les services pour le formulaire et il faudra faire en sorte que le service de l'employé soit pré sélectionné
        $categories = Category::all();
        return view('articles.edit', ['categories' => $categories, 'article' => $article]);
    }

    public function update (Request $request, Article $article) 
    {
        // lors de la mise à jour il faut controller que l'email n'existe pas déjà dans la table sauf pour celui que l'on modifie, pour cele, on précise l'id de l'employé sur la contrainte pour l'exclure du controle
        // 'email'         => 'required|email|unique:employes,email,' . $employe->id,

        // pour la photo, si une nouvelle photo a été chargé, on fait le même traitement que lors du create sinon rien
        // Il faut penser à supprimer l'ancienne photo si une nouvelle est chargée.
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'author'        => 'string|max:255',
            'category_id'   => 'nullable|exists:categories,id',
            'content'         => 'required|string|max:255',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if($request->hasFile('photo')) {
            if($article->photo) {
                Storage::disk('public')->delete($article->photo); // on supprime l'ancienne photo
            }
            $path = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = $path;
        }

        $article->update($validated);

        return redirect()->route('articles.index')->with('success', 'Modification ok !');
    }
    
    public function destroy (Article $article) 
    {
        // Il faut penser à supprimer l'ancienne photo si on supprime un employé
        if($article->photo) {
            Storage::disk('public')->delete($article->photo); // on supprime l'ancienne photo
        }

        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Suppression ok !');
    }

    public function filterByCategory($categoryName = null)
    {
        $query = Article::with('category');
        if($categoryName) {
            $category = Category::where('name', $categoryName)->first();
            if($category) {
                $query->where('category_id', $category->id);
            }
        }

        // $employes = $query->get();
        $articles = $query->orderBy('created_at', 'desc')->get();

        return view('articles.index', ['articles' => $articles]);
    }

    public function search(Request $request)
    {
        // Récupérer le terme de recherche depuis la requête
        $query = $request->input('q');

        // Rechercher dans le titre, le contenu et l'auteur
        $articles = Article::query()
            ->where('title', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->orWhere('author', 'LIKE', "%{$query}%")
            ->get();

        // Retourner une vue avec les articles trouvés
        return view('articles.search', compact('articles', 'query'));
    }
}
