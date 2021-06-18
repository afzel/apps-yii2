<aside class="main-sidebar">

    <section class="sidebar">


        <?php
            $usert = ($user && $user->isAdmin) ? ['label' => 'Пользователи', 'icon' => 'user', 'url' => ['/user/index']] : [];
        ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Чат', 'icon' => 'heart', 'url' => ['/chat']],
                    $usert,
                ],
            ]
        ) ?>

    </section>

</aside>
