<?php

namespace App\Tests\Controller;

use App\Entity\Serie;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SerieControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $serieRepository;
    private string $path = '/serie/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->followRedirects();

        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->serieRepository = $this->manager->getRepository(Serie::class);

        foreach ($this->serieRepository->findAll() as $object) {
            $this->manager->remove($object);
        }
        $this->manager->flush();
    }

    public function testIndexNoRecordsFoundInFrench(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);

        // Titre de page en FR
        self::assertPageTitleContains('Liste des séries');

        // "Nouveau" présent
        self::assertSelectorExists('a:contains("Nouveau")');

        // Aucun enregistrement -> texte FR
        self::assertSelectorTextContains('table tbody', 'pas d’entrées trouvées');
    }

    public function testNewCreatesSerieAndReturnsToList(): void
    {
        $crawler = $this->client->request('GET', sprintf('%snew', $this->path));
        self::assertResponseStatusCodeSame(200);

        // Bouton "Enregistrer"
        $this->client->submitForm('Enregistrer', [
            'serie[titre]' => 'The Witcher',   // titre d'œuvre OK en anglais
            'serie[nbtomes]' => 7,
            'serie[info]' => 'Test',
        ]);

        self::assertResponseStatusCodeSame(200);
        self::assertSame(1, $this->serieRepository->count([]));

        // De retour sur l’index : vérifier "Voir" et "Editer"
        self::assertSelectorExists('a:contains("Voir")');
        self::assertSelectorExists('a:contains("Editer")');
    }

    public function testShowDisplaysSerieAndFrenchBackLink(): void
    {
        $fixture = new Serie();
        $fixture->setTitre('My Title');
        $fixture->setNbtomes(3);
        $fixture->setInfo('My Info');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);

        // Lien FR "retour à la liste"
        self::assertSelectorExists('a:contains("retour à la liste")');

        // Bouton "Effacer" présent sur show (si tu l’affiches là)
        self::assertSelectorExists('button:contains("Effacer")');
    }

    public function testEditUpdatesSerie(): void
    {
        $fixture = new Serie();
        $fixture->setTitre('Value');
        $fixture->setNbtomes(1);
        $fixture->setInfo('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        // Bouton "Mettre à jour"
        $this->client->submitForm('Mettre à jour', [
            'serie[titre]' => 'Something New',
            'serie[nbtomes]' => 9,
            'serie[info]' => 'Something New',
        ]);

        self::assertResponseStatusCodeSame(200);

        $updated = $this->serieRepository->find($fixture->getId());
        self::assertSame('Something New', $updated->getTitre());
        self::assertSame(9, $updated->getNbtomes());
        self::assertSame('Something New', $updated->getInfo());
    }

    public function testRemoveDeletesSerie(): void
    {
        $fixture = new Serie();
        $fixture->setTitre('Value');
        $fixture->setNbtomes(2);
        $fixture->setInfo('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        // Bouton "Effacer"
        $this->client->submitForm('Effacer');

        self::assertResponseStatusCodeSame(200);
        self::assertSame(0, $this->serieRepository->count([]));

        // Index -> pas d’entrées trouvées
        self::assertSelectorTextContains('table tbody', 'pas d’entrées trouvées');
    }
}
