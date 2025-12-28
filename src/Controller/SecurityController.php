<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Utilisateur;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si déjà connecté, rediriger selon le rôle
        if ($this->getUser()) {
            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_admin_dashboard');
            }
            return $this->redirectToRoute('app_client_dashboard');
        }

        // Récupérer l'erreur de connexion s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();

        // Dernier nom d'utilisateur entré
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        // Si déjà connecté en tant qu'admin, permettre la création de compte client
        // Si déjà connecté en tant que client, rediriger vers le dashboard
        if ($this->getUser()) {
            if (!$this->isGranted('ROLE_ADMIN')) {
                // Un client déjà connecté ne peut pas s'inscrire à nouveau
                return $this->redirectToRoute('app_client_dashboard');
            }
            // Un admin peut créer un compte client
        }

        $utilisateur = new Utilisateur();
        $form = $this->createForm(RegistrationType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Hash du mot de passe
                $hashedPassword = $passwordHasher->hashPassword(
                    $utilisateur,
                    $form->get('plainPassword')->getData()
                );
                $utilisateur->setPassword($hashedPassword);
                $utilisateur->setRoles(['ROLE_USER']);

                // Créer le profil client associé
                $client = new Client();
                $client->setUser($utilisateur);
                $client->setDateInscription(new \DateTime());

                // Récupérer le téléphone depuis le formulaire si présent
                if ($form->has('telephone') && $form->get('telephone')->getData()) {
                    $client->setTelephone($form->get('telephone')->getData());
                }

                $entityManager->persist($utilisateur);
                $entityManager->persist($client);
                $entityManager->flush();

                $this->addFlash('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');

                return $this->redirectToRoute('app_login');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.');
            }
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
