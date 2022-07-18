<?php $pager->setSurroundCount(1) ?>

<nav aria-label="Page navigation">
    <ul class="pagination justify-content-end">
        <li class="page-item">
            <a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>" class="page-link">
                <span aria-hidden="true"><?= lang('Pager.first') ?></span>
            </a>
        </li>
        <li class="page-item">
            <a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>" class="page-link">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a href="<?= $link['uri'] ?>" class="page-link">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <li class="page-item">
            <a href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>" class="page-link">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        <li class="page-item">
            <a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>" class="page-link">
                <span aria-hidden="true"><?= lang('Pager.last') ?></span>
            </a>
        </li>
    </ul>
</nav>