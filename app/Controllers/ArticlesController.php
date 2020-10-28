<?php
namespace App\Controllers;
use App\Models\Article;
class ArticlesController
{
    private array $articles;
    public function index()
    {
        $articlesQuery = query()
            ->select('*')
            ->from('articles')
            ->orderBy('created_at', 'desc')
            ->execute()
            ->fetchAllAssociative();

        $articles = [];


            foreach ($articlesQuery as $article) {
                $articles[] = new Article(
                    (int)$article['id'],
                    $article['title'],
                    $article['content'],
                    $article['created_at']
                );
            }

            return require_once __DIR__ . '/../Views/ArticlesIndexView.php';
        }

        public function show(array $vars)
    {
        $articleQuery = query()
            ->select('*')
            ->from('articles')
            ->where('id = :id')
            ->setParameter('id', (int) $vars['id'])
            ->setParameter('id', (int)$vars['id'])
            ->execute()
            ->fetchAssociative();

        $article = new Article(
            (int)$articleQuery['id'],
            $articleQuery['title'],
            $articleQuery['content'],
            $articleQuery['created_at'],
        );


        return require_once __DIR__ . '/../Views/ArticlesShowView.php';
    }

        public function create()
    {
        return require_once __DIR__ . '/../Views/ArticlesCreate.php';
    }

        public function store()
    {
        if ($_POST['title'] == '' || $_POST['content'] == '') {
            $warning = "<h2 style='color: red;'>Fields cannot be empty</h2>";
            return require_once __DIR__ . '/../Views/ArticlesCreate.php';
        }
        $articleQuery = query()
            ->insert('articles')
            ->values([
                'title' => '?',
                'content' => '?'
            ])
            ->setParameter(0, $_POST['title'])
            ->setParameter(1, $_POST['content']);

        $articleQuery->execute();
        header('Location: /');
    }
    }