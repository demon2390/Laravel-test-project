<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <title>Starter Template · Bootstrap v5.3</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>


<div class="col-lg-8 mx-auto p-4 py-md-5">
    <header class="d-flex align-items-center pb-3 mb-5 border-bottom">
        <span class="fs-4">Привет</span>
    </header>

    <main>
        <div class="row g-5">
            <div class="col-md-6">
                <h2 class="text-body-emphasis">Ссылки</h2>
                <p>Ниже находятся ссылки на подключенные GUI</p>
                <ul class="list-unstyled ps-0">
                    <li>
                        <a class="icon-link mb-1" href="<?= $base_url ?>:8090" rel="noopener" target="_blank">
                            Pgadmin
                        </a>
                        LP: admin@email.example / secret
                    </li>
                    <li>
                        <a class="icon-link mb-1" href="<?= $base_url ?>:5540" rel="noopener" target="_blank">
                            RedisInsight
                        </a>
                        Redis:6379
                    </li>
                    <li>
                        <a class="icon-link mb-1" href="<?= $base_url ?>:8100" rel="noopener" target="_blank">
                            MailHog
                        </a>
                    </li>
                </ul>
            </div>

            <!--<div class="col-md-6">
                <h2 class="text-body-emphasis">Guides</h2>
                <p>Read more detailed instructions and documentation on using or contributing to Bootstrap.</p>
                <ul class="list-unstyled ps-0">
                    <li>
                        <a class="icon-link mb-1" href="/docs/5.3/getting-started/introduction/">
                            <svg class="bi" width="16" height="16">
                                <use xlink:href="#arrow-right-circle" />
                            </svg>
                            Bootstrap quick start guide
                        </a>
                    </li>
                    <li>
                        <a class="icon-link mb-1" href="/docs/5.3/getting-started/webpack/">
                            <svg class="bi" width="16" height="16">
                                <use xlink:href="#arrow-right-circle" />
                            </svg>
                            Bootstrap Webpack guide
                        </a>
                    </li>
                    <li>
                        <a class="icon-link mb-1" href="/docs/5.3/getting-started/parcel/">
                            <svg class="bi" width="16" height="16">
                                <use xlink:href="#arrow-right-circle" />
                            </svg>
                            Bootstrap Parcel guide
                        </a>
                    </li>
                    <li>
                        <a class="icon-link mb-1" href="/docs/5.3/getting-started/vite/">
                            <svg class="bi" width="16" height="16">
                                <use xlink:href="#arrow-right-circle" />
                            </svg>
                            Bootstrap Vite guide
                        </a>
                    </li>
                    <li>
                        <a class="icon-link mb-1" href="/docs/5.3/getting-started/contribute/">
                            <svg class="bi" width="16" height="16">
                                <use xlink:href="#arrow-right-circle" />
                            </svg>
                            Contributing to Bootstrap
                        </a>
                    </li>
                </ul>
            </div>-->
        </div>
    </main>
    <footer class="pt-5 my-5 text-body-secondary border-top">
        Template created by the Bootstrap team &middot; &copy; 2024
    </footer>
</div>
</body>
</html>
