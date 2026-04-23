<?php
declare(strict_types=1);

/**
 * This file is part of the LiveVoting Repository Object plugin for ILIAS.
 */

require_once __DIR__ . '/../../../../../../../../vendor/composer/vendor/autoload.php';
require_once "dir.php";

use LiveVoting\platform\ilias\LiveVotingContext;
use LiveVoting\platform\ilias\LiveVotingInitialisation;
use LiveVoting\platform\LiveVotingConfig;
use LiveVoting\player\LiveVotingInitialisationUI;
use LiveVoting\votings\LiveVotingParticipant;

global $DIC; // Lo declaramos arriba para que esté disponible en todo el archivo

$context = LiveVotingContext::getContext();

switch ($context) {
    case 1:
        LiveVotingInitialisationUI::init();
        LiveVotingParticipant::getInstance()->setIdentifier(session_id())->setType(2);
        break;
    case 2:
    default:
        LiveVotingInitialisation::init();
        // CORRECCIÓN: Acceso correcto al usuario en ILIAS 11
        LiveVotingParticipant::getInstance()->setIdentifier((string) $DIC->user()->getId())->setType(1);
        break;
}

LiveVotingConfig::load();

// CORRECCIÓN: Acceso correcto al control (ctrl)
$DIC->ctrl()->setTargetScript(LiveVotingConfig::getFullApiURL());
$DIC->ctrl()->callBaseClass();
