<footer class="footer-sticky bg-danger text-white">
    <div class="container d-flex flex-wrap justify-content-center justify-content-md-between align-items-center">
        <div class="text-center text-md-start mb-1 mb-md-0">
            <span class="fw-semibold">8BOOK</span>
            <span class="footer-tagline ms-1">| Sistem Pemesanan Lapangan</span>
        </div>
        <div class="text-center text-md-end">
            <small class="text-white-50">&copy; {{ date('Y') }} All rights reserved.</small>
        </div>
    </div>
</footer>

<style>
    html, body {
        height: 100%;
        margin: 0;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    main {
        flex: 1;
    }

    .footer-sticky {
        margin-top: auto;
        padding: 0.4rem 1rem;
        font-size: 0.75rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 -1px 3px rgba(0, 0, 0, 0.04);
    }

    .footer-tagline {
        font-weight: 400;
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.76rem;
    }

    @media (max-width: 576px) {
        .footer-sticky .container {
            flex-direction: column;
            gap: 2px;
        }

        .footer-tagline {
            display: block;
            margin-left: 0;
        }
    }
</style>
