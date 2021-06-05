<?php

use App\Entity\Post;

require_once 'vendor/autoload.php';

$post = new Post();

$post->setTitle('Dog');
$post->setBody("This is an animal");

$workflow = $this->containaer->get('workflow.post_publishing');
print_r($workflow->can($post, 'publish'));
print_r($workflow->can($post, 'to_rewview'));

try {
    $workflow->apply($post, 'to_review');
} catch (LogicException $exception) {
    // ...
}

$transitions = $workflow->getEnabledTransitions($post);

$transition = $workflow->getEnabledTransition($post, 'publish');
