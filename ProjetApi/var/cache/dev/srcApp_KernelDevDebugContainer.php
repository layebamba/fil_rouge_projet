<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerNkrLPxQ\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerNkrLPxQ/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerNkrLPxQ.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerNkrLPxQ\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerNkrLPxQ\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'NkrLPxQ',
    'container.build_id' => '2ec3d9c5',
    'container.build_time' => 1564222340,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerNkrLPxQ');