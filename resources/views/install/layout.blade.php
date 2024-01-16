<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>FleetCart</title>

        <link rel="shortcut icon" href="{{ asset('build/assets/favicon.ico') }}" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

        @routes
        @vite([
            'resources/sass/install/main.scss',
            'resources/js/install/main.js'
        ])
    </head>

    <body class="ltr">
        <div id="app" class="installer-wrapper">
            <Install
                v-cloak
                class="installer-box d-flex flex-column flex-md-row"
                :requirement-satisfied="{{ $requirement->satisfied() ? 'true' : 'false' }}"
                :permission-provided="{{ $permission->provided() ? 'true' : 'false' }}"
                inline-template
            >
                <div>
                    <aside class="installer-left-sidebar d-flex flex-column justify-content-between">
                        <div class="logo d-flex justify-content-center">
                            <svg width="501" height="500" viewBox="0 0 501 500" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M191.066 70.9022C196.064 51.467 214.421 15.4509 247.866 26.8681C281.311 38.2853 298.258 87.3307 302.55 110.426" stroke="#2F87EE" stroke-width="16.1321"/>
                                <path d="M463.352 435.897L182.541 490.344L164.658 57.7212L428.694 141.875L463.352 435.897Z" fill="#0068E1"/>
                                <path d="M130.216 90.0082L164.659 57.7213L182.542 490.344L99.6676 469.134L130.216 90.0082Z" fill="#2F87EE"/>
                                <path d="M88.4193 90.0358L130.216 90.0083L99.6674 469.134L36.5972 456.71L88.4193 90.0358Z" fill="#2779D9"/>
                                <path d="M231.039 84.4424C228.819 54.8683 235.822 -1.28106 281.587 10.7147C327.351 22.7104 353.258 94.1391 360.491 128.354" stroke="#0068E1" stroke-width="16.1321"/>
                                
                                <mask id="mask0_25_118" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="36" y="90" width="95" height="380">
                                    <path d="M88.4193 90.0359L130.216 90.0084L99.6674 469.134L36.5972 456.71L88.4193 90.0359Z" fill="#2779D9"/>
                                </mask>

                                <g mask="url(#mask0_25_118)">
                                    <circle opacity="0.2" cx="108.974" cy="463.346" r="55.7292" fill="white"/>
                                    <circle opacity="0.2" cx="132.805" cy="83.1411" r="27.498" fill="white"/>
                                    <path d="M87.7085 296.892C59.2573 284.866 38.9454 304.103 32.3459 315.224C4.97016 304.592 -28.6629 277.68 55.8109 255.095C140.285 232.51 147.471 264.506 140.505 283.327C134.761 292.859 116.16 308.918 87.7085 296.892Z" fill="white" fill-opacity="0.1"/>
                                    <path d="M154.804 200.099C118.726 172.234 73.7764 186.533 55.811 197.166C8.51452 97.8065 63.5104 215.131 103.108 153.536C142.705 91.9405 -244.833 29.9784 -47.2147 22.279C150.404 14.5795 83.6756 258.395 201.734 94.8737C296.18 -35.9434 358.655 0.280627 378.087 34.7448C387.742 79.1081 382.854 161.015 286.061 133.737C165.07 99.6398 199.9 234.93 154.804 200.099Z" fill="white" fill-opacity="0.1"/>
                                </g>

                                <mask id="mask1_25_118" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="99" y="57" width="84" height="434">
                                    <path d="M130.216 90.008L164.659 57.7211L182.542 490.344L99.6674 469.134L130.216 90.008Z" fill="#2F87EE"/>
                                </mask>

                                <g mask="url(#mask1_25_118)">
                                    <circle opacity="0.2" cx="108.974" cy="463.347" r="55.7292" fill="white"/>
                                    <circle opacity="0.2" cx="132.805" cy="83.1408" r="27.498" fill="white"/>
                                    <path d="M87.7085 296.892C59.2573 284.866 38.9454 304.102 32.3459 315.224C4.97016 304.591 -28.6629 277.68 55.8109 255.095C140.285 232.51 147.471 264.505 140.505 283.326C134.761 292.859 116.16 308.918 87.7085 296.892Z" fill="white" fill-opacity="0.1"/>
                                    <path d="M154.804 200.099C118.726 172.234 73.7764 186.533 55.811 197.166C8.51452 97.8062 63.5104 215.131 103.108 153.536C142.705 91.9402 -244.833 29.9781 -47.2147 22.2786C150.404 14.5792 83.6756 258.395 201.734 94.8733C296.18 -35.9437 358.655 0.280291 378.087 34.7444C387.742 79.1078 382.854 161.015 286.061 133.737C165.07 99.6395 199.9 234.93 154.804 200.099Z" fill="white" fill-opacity="0.1"/>
                                </g>

                                <mask id="mask2_25_118" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="164" y="57" width="300" height="434">
                                    <path d="M463.351 435.897L182.541 490.344L164.658 57.7211L428.694 141.875L463.351 435.897Z" fill="#0068E1"/>
                                </mask>
                                
                                <g mask="url(#mask2_25_118)">
                                    <path d="M223.763 142.73L238.6 402.151L286.646 392.911L280.283 298.116L337.206 312.292L334.496 265.521L278.511 251.622L275.39 199.416L381.411 225.818L378.88 181.359L223.763 142.73Z" fill="#52A2FF"/>
                                    <path d="M365.963 341.585C351.146 255.498 418.765 230.019 454.427 228.041L477.778 469.262L258.323 496.768C249.467 355.809 384.483 449.193 365.963 341.585Z" stroke="#52A2FF" stroke-width="1.46656"/>
                                    <path d="M379.187 348.955C372.734 261.841 442.493 242.996 478.179 244.462V486.811L257.096 493.044C261.862 351.888 387.253 457.847 379.187 348.955Z" fill="white" fill-opacity="0.1"/>
                                    <path d="M154.803 200.099C118.726 172.234 73.7761 186.533 55.8108 197.166C8.51427 97.8064 63.5102 215.131 103.107 153.536C142.704 91.9404 -244.834 29.9783 -47.215 22.2788C150.404 14.5794 83.6754 258.395 201.733 94.8735C296.18 -35.9435 358.655 0.280474 378.087 34.7446C387.742 79.108 382.853 161.015 286.06 133.737C165.069 99.6397 199.9 234.93 154.803 200.099Z" fill="white" fill-opacity="0.1"/>
                                </g>
                            </svg>
                        </div>

                        <ul class="step-list list-inline">
                            <li
                                class="step-list-item d-flex position-relative"
                                :class="{
                                    'active': step === 1,
                                    'complete': step >= 2
                                }"
                            >
                                <div class="icon d-flex justify-content-center align-items-center rounded-circle">
                                    <span :class="step > 1 ? 'mdi mdi-check' : 'circle rounded-circle'"></span>
                                </div>

                                <div
                                    :class="{
                                        'cursor-pointer': !appInstalled && step !== 1 && !formSubmitting
                                    }"
                                    @click="goToStep(1)"
                                >
                                    <label class="title">Requirements</label>
                                    <span class="excerpt d-block">Check system requirements</span>
                                </div>
                            </li>

                            <li
                                class="step-list-item d-flex position-relative"
                                :class="{
                                    'active': step === 2,
                                    'complete': step >= 3
                                }"
                            >
                                <div class="icon d-flex justify-content-center align-items-center rounded-circle">
                                    <span :class="step > 2 ? 'mdi mdi-check' : 'circle rounded-circle'"></span>
                                </div>

                                <div
                                    :class="{
                                        'cursor-pointer': !appInstalled && step !== 2 && !formSubmitting
                                    }"
                                    @click="goToStep(2)"
                                >
                                    <label class="title">Permissions</label>
                                    <span class="excerpt d-block">Obtain necessary permissions</span>
                                </div>
                            </li>

                            <li
                                class="step-list-item d-flex position-relative"
                                :class="{
                                    'active': step === 3 && !appInstalled,
                                    'complete': appInstalled
                                }"
                            >
                                <div class="icon d-flex justify-content-center align-items-center rounded-circle">
                                    <span :class="appInstalled ? 'mdi mdi-check' : 'circle rounded-circle'"></span>
                                </div>

                                <div
                                    :class="{
                                        'cursor-pointer': !appInstalled && step !== 3 && !formSubmitting
                                    }"
                                    @click="goToStep(3)"
                                >
                                    <label class="title">Configuration</label>
                                    <span class="excerpt d-block">Configure the application</span>
                                </div>
                            </li>

                            <li
                                class="step-list-item d-flex position-relative"
                                :class="{
                                    'complete': appInstalled
                                }"
                            >
                                <div class="icon d-flex justify-content-center align-items-center rounded-circle">
                                    <span :class="appInstalled ? 'mdi mdi-check' : 'circle rounded-circle'"></span>
                                </div>

                                <div>
                                    <label class="title">Complete</label>
                                    <span class="excerpt d-block">Installation successful</span>
                                </div>
                            </li>
                        </ul>

                        <span class="app-version">Version {{ fleetcart_version() }}</span>
                    </aside>

                    <section class="installer-main-content flex-grow-1 overflow-hidden">
                        @yield('content')
                    </section>
                </div>
            </Install>
        </div>

        @stack('scripts')
    </body>
</html>
