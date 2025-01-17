<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class Article extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'author',
        'category_id',
        'content',
        'photo',
        'excerpt',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return Storage::url($this->photo); // url de la photo
        }
        // s'il n'y a pas de photo on envoie une photo par défaut
        return asset('images/defaut_photo.png');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($article) {
            // Génération du slug si non défini ou si le titre est modifié
            if (!$article->slug || $article->isDirty('title')) {
                $article->slug = Str::slug($article->title);
            }

            // Génération de l'extrait si non défini ou si le contenu est modifié
            if (!$article->excerpt || $article->isDirty('content')) {
                $article->excerpt = $article->generateExcerpt($article->content);
            }
        });
    }

    /**
     * Génère un extrait de 150 mots maximum à partir du contenu.
     */
    public function generateExcerpt(string $content): string
    {
        // Limiter à 150 mots
        $excerpt = Str::words(strip_tags($content), 150, '...');
        return $excerpt;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}
