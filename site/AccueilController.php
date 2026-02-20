/**
 * @Route("/politique-confidentialite", name="politique_confidentialite")
 */
public function politiqueConfidentialite(): Response
{
    return $this->render('Accueil/politique_confidentialite.html.twig');
}
