# CopierCare : la solution reprographique complète !

Bienvenue sur CopierCare, l'application web de gestion du parc reprographique de multifonctions.

## Table des Matières
1. [Introduction](#Introduction)
2. [Fonctionnement](#Fonctionnement)
3. [Prérequis](#Prérequis)
4. [Téléchargement](#Téléchargement)
5. [Installation](#Installation)
6. [Utilisation](#Utilisation)
***
## Introduction

CopierCare est une application wen de suivi en ligne du parc reprographique de multifonctions de l'entreprise Office Center. Elle permet de faciliter la gestion du parc actuel et de permettre l'ajout de nouveaux équipements grâce à un formulaire d'ajout. La saisie des interventions est également possible pour permettre une meilleure navigation et une accessibilité optimale pour le technicien sur site. De plus, l'application web offre des alertes automatiques pour prévenir l'usure des pièces et la fréquence des pannes. 

## Fonctionnement 

CopierCare est une application web développée avec PHP 8 et JavaScript, et utilise une base de données MySQL pour stocker les données du parc et des clients. L'application dispose d'une interface utilisateur ergonomique et fluide, avec une charte graphique professionnelle et épurée et une navigation fluide et instinctive. 

## Prérequis

Les prérequis pour utiliser l'application CopierCare sont les suivants : 

- Un serveur web (Apache recommandé)
- PHP version 7.3 ou supérieure
- MySQL version 5.7 ou supérieure

## Téléchargement

Le code source de l'application est disponible sur GitHub à l'adresse suivante : https://github.com/JohanGoutorbe/copierCare

## Installation

Pour installer l'application CopierCare sur votre serveur ou votre poste, vous pouvez suivre les étapes d'installation suivantes : 

1. Clonez le dépôt Git sur votre serveur web.
2. Créez une base de données MySQL nommée copiercarev1_db (ou modifiez le fichier dbconnect.php dans /utils/) pour stocker les données du parc et des clients.
3. Importez le fichier script.sql (https://github.com/JohanGoutorbe/CopierCare/blob/main/utils/sql/copiercare.sql) dans la base de données que vous venez de créer
4. Mettez à jour les informations de connexion à la base de données dans le fichier dbconfig.php (nom de la base, utilisateur, mot de passe).
5. Ouvrez u votre navigateur et accédez à l'url où vous avez installé l'application.

## Utilisation

Pour utiliser l'application CopierCare, vous devez vous connecter avec les identifiants fournis par l'administrateur de l'application. Une fois connecté, vous pouvez accéder à toutes les fonctionnalités de l'applciation, notamment la gestion du parc et des clients, la saisie des interventions, la génération des rapports, etc.
