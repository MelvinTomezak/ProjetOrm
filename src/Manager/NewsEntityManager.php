<?php

namespace App\Manager;

use App\Repository\NewsRepository;
use App\Model\News;
use App\Model\VO\Uid;
use InvalidArgumentException;

class NewsEntityManager
{
    private NewsRepository $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function createNews(string $content): News
    {
        $news = new News();
        $news->setContent($content);
        $news->setCreatedAt(new \DateTimeImmutable()); // Initialise la date de création

        // Assure-toi que l'ID est généré avant la sauvegarde, par exemple, en utilisant un générateur d'ID.
        $uid = new Uid(uniqid('news_', true));
        $news->setId($uid);

        // Sauvegarde la nouvelle instance de News
        $this->newsRepository->save($news);

        return $news;
    }

    public function updateNews(News $news): void
    {
        // Assure-toi que l'ID de l'entité existe avant de tenter de la mettre à jour
        if ($news->getId() === null) {
            throw new InvalidArgumentException("L'objet News doit avoir un ID pour être mis à jour.");
        }

        $this->newsRepository->update($news);
    }

    public function deleteNews(Uid $id): void
    {
        $this->newsRepository->delete($id);
    }

    public function findNewsById(Uid $id): ?News
    {
        return $this->newsRepository->findById($id);
    }

    public function getAllNews(): array
    {
        return $this->newsRepository->findAll();
    }
}
