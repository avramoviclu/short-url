<?php

declare(strict_types=1);

namespace ShortUrl\Services;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ShortUrl\Database\MySqlConnection;
use PDO;

class UrlService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = MySqlConnection::getInstance()->connect();
    }

    public function shorten(string $longUrl): string
    {
        $id = $this->storeLongUrl($longUrl);

        $shortUrl = $this->convertIdToShortUrl($id);

        $this->storeShortUrl($shortUrl, $id);

        return $shortUrl;
    }

    private function storeShortUrl(string $shortUrl, int $id): int
    {
        $sql = "UPDATE url SET short_url = :shortUrl WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->execute([
            'shortUrl' => $shortUrl,
            'id' => $id
        ]);

        return $id;
    }

    private function storeLongUrl(string $longUrl): int
    {
        $sql = "INSERT INTO url (long_url) VALUES (:longUrl)";
        
        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'longUrl' => $longUrl
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function redirect(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $response->getBody()->write("Hello world!");
        
        return $response;
    }

    private function convertIdToShortUrl(float $id): string
    {
        $map = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $shortUrl = '';

        while ($id) {
            $shortUrl .= $map[$id % 62];
            $id = intval($id / 62);
        }

        $shortUrl = strrev($shortUrl);

        return $shortUrl;
    }
}