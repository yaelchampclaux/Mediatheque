<?php

namespace App\Tests\Controller;

use App\Entity\Auteur;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AuteurControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $auteurRepository;
    private string $path = '/auteur/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->auteurRepository = $this->manager->getRepository(Auteur::class);

        foreach ($this->auteurRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Auteur index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'auteur[nomoupseudo]' => 'Testing',
            'auteur[prenom]' => 'Testing',
            'auteur[type]' => 'Testing',
            'auteur[oeuvres]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->auteurRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Auteur();
        $fixture->setNomoupseudo('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setType('My Title');
        $fixture->setOeuvres('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Auteur');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Auteur();
        $fixture->setNomoupseudo('Value');
        $fixture->setPrenom('Value');
        $fixture->setType('Value');
        $fixture->setOeuvres('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'auteur[nomoupseudo]' => 'Something New',
            'auteur[prenom]' => 'Something New',
            'auteur[type]' => 'Something New',
            'auteur[oeuvres]' => 'Something New',
        ]);

        self::assertResponseRedirects('/auteur/');

        $fixture = $this->auteurRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomoupseudo());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getOeuvres());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Auteur();
        $fixture->setNomoupseudo('Value');
        $fixture->setPrenom('Value');
        $fixture->setType('Value');
        $fixture->setOeuvres('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/auteur/');
        self::assertSame(0, $this->auteurRepository->count([]));
    }
}
