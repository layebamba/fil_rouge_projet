<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerI5hGVjg\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerI5hGVjg/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerI5hGVjg.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerI5hGVjg\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerI5hGVjg\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'I5hGVjg',
    'container.build_id' => 'ad4e1145',
    'container.build_time' => 1564584267,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerI5hGVjg');
