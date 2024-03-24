    <footer class="bg-dark navbar-dark navbar">
        <ul class="d-flex flex-wrap flex-row justify-content-center w-100 navbar-nav">
            <li class="nav-item"><a class="nav-link text-center">&copy; <?= (new DateTime)->format('Y') ?></a></li>
            <li class="nav-item"><a class="nav-link text-center" href="https://github.com/grahamogden/dragon-companion/issues" target="_blank"><i class="fa fa-bug"></i>Feedback/Bug Report</a></li>
        </ul>
    </footer>
    <?= $this->Html->script('js/service-worker.js') ?>