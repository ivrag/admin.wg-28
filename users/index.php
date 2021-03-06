<?php
session_start();
if (!empty($_SESSION["wg28-user"]) && $_SESSION["auth"] === True) {
  $page = "users";

  require_once dirname(__FILE__) . "/../config.php";

  require_once ROOT."assets/php/autoload.php";

  $db = new DataController($_AdminUsers);
  $data = $db->selectId(intval($_SESSION["wg28-user"]["id"]));

  if (intval($data["user_rights"]) === 1) {
?>

<!DOCTYPE html>
<html lang="de">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Immobilien Von Rehetobel AG">

  <!-- favicon -->
  <link rel="icon" type="image/svg+xml" href="../lib/img/logo/logo-ivr-dark.svg" sizes="any">

  <title>Benutzer &bull; ivrag-admin</title>

  <!-- Custom fonts for this template-->
  <link href="../node_modules/startbootstrap-sb-admin-2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link rel="stylesheet" href="../node_modules/startbootstrap-sb-admin-2/css/sb-admin-2.min.css">
  <link rel="stylesheet" href="../assets/sb-admin/css/sb-admin-2.custom.css">
  <link rel="stylesheet" href="../assets/css/default/default.styles.css">

  <!-- Shoelace -->
  <link rel="stylesheet" href="../node_modules/@shoelace-style/shoelace/dist/shoelace/shoelace.css">

  <!-- Custom -->
  <link rel="stylesheet" href="./style.css">

</head>

<body id="page-top">
  <input id="main-page-input" type="hidden" value="1">
  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <?php require_once ROOT."assets/client/sidebar.php" ?>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <div class="load-screen">
        <svg class="background-brand" width="4000" height="503" viewBox="0 0 4000 503" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M231.797 60.7999C236.291 55.0219 245.921 53.0959 268.391 53.0959H339.01C369.313 53.0959 381.596 75.7797 383.95 87.1217L510.423 475.53H625.983C666.001 350.127 747.063 96.88 751.172 87.1217C762.985 59.3874 788.194 52.4539 799.322 52.4539H900.115C968.167 52.4539 976.513 238.633 900.115 238.633H841.694V263.671C856.246 261.745 887.275 263.671 900.115 263.671C919.118 263.671 928.149 300.051 930.289 318.24C931.145 330.866 933.628 361.511 936.709 383.082C942.029 420.318 956.641 439.299 977.155 454.986C1009.38 479.629 1100.07 476.908 1143.93 475.592L1146 475.53V454.986C1113.9 448.566 1105.46 429.306 1089.5 343.92C1078.59 285.499 1013.11 253.399 968.167 248.905V243.769C1044.56 243.769 1105.55 212.334 1105.55 132.703C1105.55 108.95 1097.85 25.49 995.773 28.058H727.418L628.551 375.378L526.473 28.058H27V52.4539C49.4699 52.4539 59.0998 54.3799 63.5938 60.1579C67.189 64.7802 66.5898 72.5698 66.8038 74.9237V433.158C66.5898 435.512 67.189 443.302 63.5938 447.924C59.0998 453.702 51.3959 455.628 28.926 455.628V475.53H268.391V455.628C245.921 455.628 236.291 453.702 231.797 447.924C228.202 443.302 228.801 435.512 228.587 433.158V75.5657C228.801 73.2117 228.202 65.4222 231.797 60.7999Z" fill="#C4C4C4"/>
          <path d="M1188.43 340.477H1162.42V190.194H1188.43V340.477ZM1241.69 228.797L1242.41 240.46C1250.25 231.309 1260.99 226.733 1274.61 226.733C1289.54 226.733 1299.76 232.444 1305.27 243.867C1313.39 232.444 1324.81 226.733 1339.54 226.733C1351.85 226.733 1361 230.139 1366.99 236.951C1373.05 243.763 1376.14 253.81 1376.28 267.09V340.477H1351.2V267.813C1351.2 260.725 1349.65 255.53 1346.55 252.227C1343.46 248.924 1338.33 247.273 1331.17 247.273C1325.46 247.273 1320.78 248.821 1317.14 251.917C1313.56 254.945 1311.05 258.936 1309.6 263.891L1309.71 340.477H1284.62V266.987C1284.28 253.844 1277.57 247.273 1264.5 247.273C1254.45 247.273 1247.33 251.367 1243.13 259.555V340.477H1218.05V228.797H1241.69ZM1425.62 228.797L1426.34 240.46C1434.18 231.309 1444.92 226.733 1458.54 226.733C1473.48 226.733 1483.69 232.444 1489.2 243.867C1497.32 232.444 1508.74 226.733 1523.47 226.733C1535.78 226.733 1544.94 230.139 1550.92 236.951C1556.98 243.763 1560.07 253.81 1560.21 267.09V340.477H1535.13V267.813C1535.13 260.725 1533.58 255.53 1530.49 252.227C1527.39 248.924 1522.26 247.273 1515.11 247.273C1509.39 247.273 1504.72 248.821 1501.07 251.917C1497.49 254.945 1494.98 258.936 1493.53 263.891L1493.64 340.477H1468.56V266.987C1468.21 253.844 1461.5 247.273 1448.43 247.273C1438.38 247.273 1431.26 251.367 1427.06 259.555V340.477H1401.98V228.797H1425.62ZM1581.27 283.605C1581.27 272.664 1583.44 262.824 1587.77 254.085C1592.11 245.277 1598.2 238.534 1606.04 233.855C1613.88 229.107 1622.9 226.733 1633.08 226.733C1648.15 226.733 1660.37 231.584 1669.72 241.286C1679.15 250.989 1684.24 263.856 1685 279.889L1685.1 285.772C1685.1 296.782 1682.97 306.622 1678.7 315.292C1674.51 323.963 1668.45 330.672 1660.54 335.42C1652.69 340.168 1643.61 342.542 1633.29 342.542C1617.53 342.542 1604.9 337.312 1595.41 326.853C1585.98 316.325 1581.27 302.321 1581.27 284.844V283.605ZM1606.35 285.772C1606.35 297.264 1608.72 306.278 1613.47 312.815C1618.22 319.283 1624.83 322.518 1633.29 322.518C1641.75 322.518 1648.32 319.215 1653 312.609C1657.75 306.003 1660.13 296.335 1660.13 283.605C1660.13 272.32 1657.68 263.374 1652.8 256.769C1647.98 250.163 1641.41 246.86 1633.08 246.86C1624.89 246.86 1618.39 250.128 1613.57 256.665C1608.76 263.134 1606.35 272.836 1606.35 285.772ZM1804.32 285.772C1804.32 303.113 1800.43 316.909 1792.66 327.162C1784.95 337.415 1774.32 342.542 1760.76 342.542C1747.69 342.542 1737.5 337.828 1730.21 328.401L1728.97 340.477H1706.26V181.937H1731.34V239.531C1738.57 230.999 1748.31 226.733 1760.55 226.733C1774.18 226.733 1784.88 231.79 1792.66 241.905C1800.43 252.021 1804.32 266.161 1804.32 284.327V285.772ZM1779.24 283.605C1779.24 271.494 1777.1 262.411 1772.84 256.356C1768.57 250.3 1762.38 247.273 1754.26 247.273C1743.39 247.273 1735.75 252.021 1731.34 261.517V307.551C1735.82 317.253 1743.52 322.105 1754.47 322.105C1762.31 322.105 1768.36 319.18 1772.63 313.331C1776.9 307.482 1779.1 298.64 1779.24 286.805V283.605ZM1852.11 340.477H1827.03V228.797H1852.11V340.477ZM1825.48 199.793C1825.48 195.94 1826.68 192.74 1829.09 190.194C1831.57 187.648 1835.08 186.375 1839.62 186.375C1844.16 186.375 1847.67 187.648 1850.15 190.194C1852.62 192.74 1853.86 195.94 1853.86 199.793C1853.86 203.578 1852.62 206.743 1850.15 209.289C1847.67 211.766 1844.16 213.005 1839.62 213.005C1835.08 213.005 1831.57 211.766 1829.09 209.289C1826.68 206.743 1825.48 203.578 1825.48 199.793ZM1906.19 340.477H1881.11V181.937H1906.19V340.477ZM1960.28 340.477H1935.2V228.797H1960.28V340.477ZM1933.65 199.793C1933.65 195.94 1934.85 192.74 1937.26 190.194C1939.74 187.648 1943.25 186.375 1947.79 186.375C1952.33 186.375 1955.84 187.648 1958.32 190.194C1960.79 192.74 1962.03 195.94 1962.03 199.793C1962.03 203.578 1960.79 206.743 1958.32 209.289C1955.84 211.766 1952.33 213.005 1947.79 213.005C1943.25 213.005 1939.74 211.766 1937.26 209.289C1934.85 206.743 1933.65 203.578 1933.65 199.793ZM2036.87 342.542C2020.97 342.542 2008.07 337.553 1998.16 327.575C1988.32 317.529 1983.4 304.179 1983.4 287.527V284.431C1983.4 273.283 1985.53 263.34 1989.8 254.601C1994.13 245.793 2000.19 238.947 2007.96 234.061C2015.74 229.175 2024.41 226.733 2033.98 226.733C2049.18 226.733 2060.91 231.584 2069.17 241.286C2077.5 250.989 2081.66 264.716 2081.66 282.47V292.585H2008.69C2009.44 301.805 2012.51 309.099 2017.87 314.467C2023.31 319.834 2030.12 322.518 2038.31 322.518C2049.8 322.518 2059.16 317.873 2066.39 308.583L2079.91 321.485C2075.43 328.16 2069.45 333.355 2061.95 337.071C2054.52 340.718 2046.15 342.542 2036.87 342.542ZM2033.87 246.86C2026.99 246.86 2021.42 249.268 2017.15 254.085C2012.95 258.902 2010.27 265.611 2009.1 274.212H2056.89V272.354C2056.34 263.959 2054.1 257.629 2050.18 253.362C2046.26 249.027 2040.82 246.86 2033.87 246.86ZM2124.5 228.797L2125.22 241.699C2133.48 231.721 2144.31 226.733 2157.73 226.733C2180.99 226.733 2192.83 240.048 2193.24 266.677V340.477H2168.16V268.122C2168.16 261.035 2166.61 255.805 2163.51 252.434C2160.48 248.993 2155.5 247.273 2148.55 247.273C2138.43 247.273 2130.9 251.849 2125.94 261.001V340.477H2100.86V228.797H2124.5ZM2326.9 307.758L2365.09 190.194H2393.79L2339.7 340.477H2314.41L2260.54 190.194H2289.13L2326.9 307.758ZM2398.95 283.605C2398.95 272.664 2401.12 262.824 2405.45 254.085C2409.79 245.277 2415.88 238.534 2423.72 233.855C2431.57 229.107 2440.58 226.733 2450.76 226.733C2465.83 226.733 2478.05 231.584 2487.41 241.286C2496.83 250.989 2501.92 263.856 2502.68 279.889L2502.78 285.772C2502.78 296.782 2500.65 306.622 2496.38 315.292C2492.19 323.963 2486.13 330.672 2478.22 335.42C2470.37 340.168 2461.29 342.542 2450.97 342.542C2435.21 342.542 2422.59 337.312 2413.09 326.853C2403.66 316.325 2398.95 302.321 2398.95 284.844V283.605ZM2424.03 285.772C2424.03 297.264 2426.4 306.278 2431.15 312.815C2435.9 319.283 2442.51 322.518 2450.97 322.518C2459.43 322.518 2466 319.215 2470.68 312.609C2475.43 306.003 2477.81 296.335 2477.81 283.605C2477.81 272.32 2475.36 263.374 2470.48 256.769C2465.66 250.163 2459.09 246.86 2450.76 246.86C2442.57 246.86 2436.07 250.128 2431.26 256.665C2426.44 263.134 2424.03 272.836 2424.03 285.772ZM2547.27 228.797L2547.99 241.699C2556.25 231.721 2567.09 226.733 2580.51 226.733C2603.76 226.733 2615.6 240.048 2616.01 266.677V340.477H2590.93V268.122C2590.93 261.035 2589.38 255.805 2586.29 252.434C2583.26 248.993 2578.27 247.273 2571.32 247.273C2561.2 247.273 2553.67 251.849 2548.72 261.001V340.477H2523.63V228.797H2547.27ZM2751.95 282.573H2722.84V340.477H2696.73V190.194H2749.58C2766.92 190.194 2780.3 194.082 2789.73 201.857C2799.15 209.633 2803.87 220.884 2803.87 235.609C2803.87 245.656 2801.42 254.085 2796.54 260.897C2791.72 267.641 2784.98 272.836 2776.31 276.483L2810.06 339.135V340.477H2782.09L2751.95 282.573ZM2722.84 261.62H2749.68C2758.49 261.62 2765.37 259.418 2770.32 255.014C2775.28 250.541 2777.75 244.451 2777.75 236.745C2777.75 228.694 2775.45 222.466 2770.84 218.062C2766.3 213.659 2759.48 211.388 2750.4 211.25H2722.84V261.62ZM2875.4 342.542C2859.5 342.542 2846.6 337.553 2836.69 327.575C2826.85 317.529 2821.93 304.179 2821.93 287.527V284.431C2821.93 273.283 2824.06 263.34 2828.33 254.601C2832.66 245.793 2838.72 238.947 2846.5 234.061C2854.27 229.175 2862.94 226.733 2872.51 226.733C2887.71 226.733 2899.45 231.584 2907.7 241.286C2916.03 250.989 2920.19 264.716 2920.19 282.47V292.585H2847.22C2847.97 301.805 2851.04 309.099 2856.4 314.467C2861.84 319.834 2868.65 322.518 2876.84 322.518C2888.33 322.518 2897.69 317.873 2904.92 308.583L2918.44 321.485C2913.96 328.16 2907.98 333.355 2900.48 337.071C2893.05 340.718 2884.69 342.542 2875.4 342.542ZM2872.4 246.86C2865.52 246.86 2859.95 249.268 2855.68 254.085C2851.48 258.902 2848.8 265.611 2847.63 274.212H2895.42V272.354C2894.87 263.959 2892.63 257.629 2888.71 253.362C2884.79 249.027 2879.35 246.86 2872.4 246.86ZM2964.47 240.977C2972.66 231.481 2983.02 226.733 2995.54 226.733C3019.35 226.733 3031.42 240.323 3031.77 267.503V340.477H3006.69V268.432C3006.69 260.725 3005 255.289 3001.63 252.124C2998.33 248.89 2993.44 247.273 2986.97 247.273C2976.93 247.273 2969.43 251.745 2964.47 260.691V340.477H2939.39V181.937H2964.47V240.977ZM3106.39 342.542C3090.5 342.542 3077.6 337.553 3067.69 327.575C3057.85 317.529 3052.93 304.179 3052.93 287.527V284.431C3052.93 273.283 3055.06 263.34 3059.33 254.601C3063.66 245.793 3069.72 238.947 3077.49 234.061C3085.27 229.175 3093.94 226.733 3103.5 226.733C3118.71 226.733 3130.44 231.584 3138.7 241.286C3147.03 250.989 3151.19 264.716 3151.19 282.47V292.585H3078.22C3078.97 301.805 3082.04 309.099 3087.4 314.467C3092.84 319.834 3099.65 322.518 3107.84 322.518C3119.33 322.518 3128.69 317.873 3135.91 308.583L3149.44 321.485C3144.96 328.16 3138.98 333.355 3131.48 337.071C3124.04 340.718 3115.68 342.542 3106.39 342.542ZM3103.4 246.86C3096.52 246.86 3090.95 249.268 3086.68 254.085C3082.48 258.902 3079.8 265.611 3078.63 274.212H3126.42V272.354C3125.87 263.959 3123.63 257.629 3119.71 253.362C3115.79 249.027 3110.35 246.86 3103.4 246.86ZM3202.18 201.651V228.797H3221.89V247.376H3202.18V309.719C3202.18 313.985 3203 317.081 3204.66 319.008C3206.38 320.866 3209.4 321.795 3213.74 321.795C3216.63 321.795 3219.55 321.451 3222.51 320.763V340.168C3216.8 341.75 3211.3 342.542 3206 342.542C3186.73 342.542 3177.1 331.91 3177.1 310.648V247.376H3158.73V228.797H3177.1V201.651H3202.18ZM3233.35 283.605C3233.35 272.664 3235.52 262.824 3239.85 254.085C3244.19 245.277 3250.28 238.534 3258.12 233.855C3265.97 229.107 3274.98 226.733 3285.17 226.733C3300.23 226.733 3312.45 231.584 3321.81 241.286C3331.23 250.989 3336.33 263.856 3337.08 279.889L3337.19 285.772C3337.19 296.782 3335.05 306.622 3330.79 315.292C3326.59 323.963 3320.53 330.672 3312.62 335.42C3304.78 340.168 3295.69 342.542 3285.37 342.542C3269.61 342.542 3256.99 337.312 3247.49 326.853C3238.06 316.325 3233.35 302.321 3233.35 284.844V283.605ZM3258.43 285.772C3258.43 297.264 3260.81 306.278 3265.55 312.815C3270.3 319.283 3276.91 322.518 3285.37 322.518C3293.84 322.518 3300.41 319.215 3305.09 312.609C3309.83 306.003 3312.21 296.335 3312.21 283.605C3312.21 272.32 3309.77 263.374 3304.88 256.769C3300.06 250.163 3293.49 246.86 3285.17 246.86C3276.98 246.86 3270.47 250.128 3265.66 256.665C3260.84 263.134 3258.43 272.836 3258.43 285.772ZM3456.4 285.772C3456.4 303.113 3452.51 316.909 3444.74 327.162C3437.03 337.415 3426.4 342.542 3412.84 342.542C3399.77 342.542 3389.59 337.828 3382.29 328.401L3381.05 340.477H3358.35V181.937H3383.43V239.531C3390.65 230.999 3400.39 226.733 3412.64 226.733C3426.26 226.733 3436.96 231.79 3444.74 241.905C3452.51 252.021 3456.4 266.161 3456.4 284.327V285.772ZM3431.32 283.605C3431.32 271.494 3429.19 262.411 3424.92 256.356C3420.65 250.3 3414.46 247.273 3406.34 247.273C3395.47 247.273 3387.83 252.021 3383.43 261.517V307.551C3387.9 317.253 3395.61 322.105 3406.55 322.105C3414.39 322.105 3420.45 319.18 3424.71 313.331C3428.98 307.482 3431.18 298.64 3431.32 286.805V283.605ZM3526.69 342.542C3510.8 342.542 3497.89 337.553 3487.99 327.575C3478.15 317.529 3473.23 304.179 3473.23 287.527V284.431C3473.23 273.283 3475.36 263.34 3479.63 254.601C3483.96 245.793 3490.02 238.947 3497.79 234.061C3505.57 229.175 3514.24 226.733 3523.8 226.733C3539.01 226.733 3550.74 231.584 3559 241.286C3567.32 250.989 3571.49 264.716 3571.49 282.47V292.585H3498.51C3499.27 301.805 3502.33 309.099 3507.7 314.467C3513.14 319.834 3519.95 322.518 3528.14 322.518C3539.63 322.518 3548.99 317.873 3556.21 308.583L3569.73 321.485C3565.26 328.16 3559.27 333.355 3551.77 337.071C3544.34 340.718 3535.98 342.542 3526.69 342.542ZM3523.7 246.86C3516.82 246.86 3511.24 249.268 3506.98 254.085C3502.78 258.902 3500.1 265.611 3498.93 274.212H3546.72V272.354C3546.17 263.959 3543.93 257.629 3540.01 253.362C3536.08 249.027 3530.65 246.86 3523.7 246.86ZM3617.73 340.477H3592.65V181.937H3617.73V340.477ZM3784.32 305.487H3726.11L3713.93 340.477H3686.78L3743.55 190.194H3766.98L3823.85 340.477H3796.6L3784.32 305.487ZM3733.43 284.431H3776.99L3755.21 222.088L3733.43 284.431ZM3953.9 320.969C3948.47 328.057 3940.93 333.424 3931.3 337.071C3921.67 340.718 3910.73 342.542 3898.48 342.542C3885.88 342.542 3874.74 339.686 3865.04 333.975C3855.33 328.263 3847.83 320.109 3842.53 309.512C3837.3 298.847 3834.59 286.426 3834.38 272.251V260.484C3834.38 237.777 3839.82 220.058 3850.69 207.328C3861.56 194.529 3876.73 188.13 3896.21 188.13C3912.93 188.13 3926.21 192.258 3936.05 200.516C3945.89 208.773 3951.81 220.677 3953.8 236.229H3928.2C3925.31 218.131 3914.82 209.083 3896.72 209.083C3885.02 209.083 3876.11 213.315 3869.99 221.778C3863.93 230.173 3860.8 242.525 3860.6 258.833V270.393C3860.6 286.633 3864 299.259 3870.82 308.274C3877.7 317.219 3887.23 321.692 3899.41 321.692C3912.76 321.692 3922.25 318.664 3927.89 312.609V283.192H3896.93V263.374H3953.9V320.969Z" fill="#C4C4C4"/>
        </svg>
      </div>

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
              <i class="fa fa-bars"></i>
          </button>

          <div class="mt-2 ml-0">
            <h1 class="h3 text-gray-800">Benutzer</h1>
          </div>

          <?php require_once ROOT."assets/client/topnav.php" ?>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid" id="main-content-section">
          
          <!-- Content Row -->
          <div class="row">

            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
              <sl-alert id="main-success-alert" type="success" class="mb-4">
                <sl-icon slot="icon" name="check2-circle"></sl-icon>
                <strong id="main-success-alert-title"></strong><br>
                <span id="main-success-alert-message"></span>
              </sl-alert>
              <sl-alert id="main-warning-alert" type="warning" class="mb-4">
                <sl-icon slot="icon" name="exclamation-triangle"></sl-icon>
                <strong id="main-warning-alert-title"></strong><br>
                <span id="main-warning-alert-message"></span>
              </sl-alert>
              <!-- Project Card Example -->
              <div class="card shadow mb-4">
                <div class="card-header d-sm-flex align-items-center justify-content-between py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Benutzertabelle</h6>
                  <form id="user-search-form">
                    <div class="input-group">
                      <input type="text" id="user-search-input" class="form-control" placeholder="Suchen...">
                      <div class="input-group-append">
                      <button id="user-search-submit" class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                      </div>
                    </div>
                  </form>
                  <div>
                    Datensätze: <select id="dataset-select" class="ml-2">
                      <option value="20" selected>20</option>
                      <option value="50">50</option>
                      <option value="100">100</option>
                      <option value="250">250</option>
                      <option value="500" title="Bei dieser Datenmänge können verzögerungen entstehen">500</option>
                    </select>
                  </div>
                  <button title="Benutzer hinzufügen" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#new-user-modal">
                    <i class="fas fa-user-plus"></i>
                    Benutzer
                  </button>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                      <thead>
                        <tr role="row">
                          <th>Vorname</th>
                          <th>Nachname</th>
                          <th>Benutzername</th>
                          <th>E-Mail</th>
                          <th>Aktionen</th>
                        </tr>
                      </thead>
                      <tbody id="user-table-body"></tbody>
                      <tfoot id="user-table-footer"></tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <?php require_once ROOT."assets/client/footer.php" ?>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


  <!-- NEW USER MODAL -->
  <div class="modal fade" id="new-user-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="new-user-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Benutzer hinzufügen</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="new-user-form">
            <sl-alert id="new-user-error-alert" type="warning" class="mb-3">
              <sl-icon slot="icon" name="exclamation-triangle"></sl-icon>
              <strong id="new-user-error-title"></strong><br>
              <span id="new-user-error-message"></span>
            </sl-alert>
            <div class="form-row mb-3">
              <div class="col">
                <label for="new-user-firstname-input">Vorname *</label>
                <input id="new-user-firstname-input" type="text" class="form-control">
              </div>
              <div class="col">
                <label for="new-user-lastname-input">Nachname *</label>
                <input id="new-user-lastname-input" type="text" class="form-control">
              </div>
            </div>
            <div class="form-row mb-3">
              <div class="col">
                <label for="new-user-username-input">Benutzername *</label>
                <input id="new-user-username-input" type="text" class="form-control">
                <small class="form-text">A-Z, a-z, 0-9, -, . | Mindestens 5 Zeichen</small>
              </div>
              <div class="col">
                <label for="new-user-email-input">E-Mail *</label>
                <input id="new-user-email-input" type="text" class="form-control">
              </div>
            </div>
            <div class="form-row mb-5">
              <div class="col">
                <label for="new-user-password-input">Passwort *</label>
                <input id="new-user-password-input" type="password" class="form-control" autocomplete="off">
                <small class="form-text">Mindestens 6 Zeichen</small>
              </div>
              <div class="col">
                <label for="new-user-password-repeat-input">Passwort wiederholen *</label>
                <input id="new-user-password-repeat-input" type="password" class="form-control" autocomplete="off">
                <small class="form-text">Mindestens 6 Zeichen</small>
              </div>
            </div>

            <h5>Rechte</h5>
            <hr>
            <div class="form-row mb-4">
              <div class="col">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="user-rights-switch">
                  <label class="custom-control-label" for="user-rights-switch">Benutzerrechte</label>
                  <small class="form-text">Dieser Benutzer kann andere Benutzer dieser Applikation sehen, bearbeiten und löschen.</small>
                </div>
              </div>
              <div class="col">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="user-ads-switch">
                  <label class="custom-control-label" for="user-ads-switch">Inserierungsrechte</label>
                  <small class="form-text">Dieser Benutzer kann Inserate erstellen, bearbeiten und löschen.</small>
                </div>
              </div>
            </div>
            <div class="form-row mb-4">
              <div class="col">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="user-address-switch">
                  <label class="custom-control-label" for="user-address-switch">Adressenrechte</label>
                  <small class="form-text">Dieser Benutzer kann Adressen bearbeiten.</small>
                </div>
              </div>
              <div class="col">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="user-terms-switch">
                  <label class="custom-control-label" for="user-terms-switch">Richtlinien</label>
                  <small class="form-text">Dieser Benutzer kann Richtlinien bearbeiten.</small>
                </div>
              </div>
            </div>
            <div class="form-row mb-2">
              <div class="col">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="user-ip-switch">
                  <label class="custom-control-label" for="user-ip-switch">IP-Rechte</label>
                  <small class="form-text">Dieser Benutzer kann IP-Adressen erstellen, bearbeiten und löschen.</small>
                </div>
              </div>
              <div class="col">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="user-newsletter-switch">
                  <label class="custom-control-label" for="user-newsletter-switch">Newsletterrechte</label>
                  <small class="form-text">Dieser Benutzer kann newsletter versenden.</small>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2"></i> Benutzer hinzufügen</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- UDATE USER MODAL -->
  <div class="modal fade" id="update-user-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="update-user-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Benutzer bearbeiten</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h5>Benutzerinformationen</h5>
          <hr>
          <div class="row">
            <div class="col-md-6 mb-3">
              Vorname
              <div><strong id="update-user-firstname-output"></strong></div>
            </div>
            <div class="col-md-6 mb-3">
              Nachname
              <div><strong id="update-user-lastname-output"></strong></div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              Benutzername
              <div><strong id="update-user-username-output"></strong></div>
            </div>
            <div class="col-md-6 mb-3">
              E-Mail
              <div><strong id="update-user-email-output"></strong></div>
            </div>
          </div>

          <h5 class="mt-3">Rechte</h5>
          <hr>
          <sl-alert id="update-error-alert" type="warning" class="mb-3">
            <sl-icon slot="icon" name="exclamation-triangle"></sl-icon>
            <strong id="update-error-alert-title"></strong><br>
            <span id="update-error-alert-message"></span>
          </sl-alert>
          <form id="update-user-rights-form">
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="update-users-user-switch">
                  <label class="custom-control-label" for="update-users-user-switch">Benutzerrechte</label>
                  <small class="form-text">Dieser Benutzer kann andere Benutzer dieser Applikation sehen, bearbeiten und löschen.</small>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="update-ads-user-switch">
                  <label class="custom-control-label" for="update-ads-user-switch">Inserierungsrechte</label>
                  <small class="form-text">Dieser Benutzer kann Inserate erstellen, bearbeiten und löschen.</small>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="update-address-user-switch">
                  <label class="custom-control-label" for="update-address-user-switch">Adressenrechte</label>
                  <small class="form-text">Dieser Benutzer kann Adressen bearbeiten.</small>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="update-terms-user-switch">
                  <label class="custom-control-label" for="update-terms-user-switch">Richtlinien</label>
                  <small class="form-text">Dieser Benutzer kann Richtlinien bearbeiten.</small>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="update-ip-user-switch">
                  <label class="custom-control-label" for="update-ip-user-switch">IP-Rechte</label>
                  <small class="form-text">Dieser Benutzer kann IP-Adressen erstellen, bearbeiten und löschen.</small>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="update-newsletter-user-switch">
                  <label class="custom-control-label" for="update-newsletter-user-switch">Newsletterrechte</label>
                  <small class="form-text">Dieser Benutzer kann newsletter versenden.</small>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button id="update-user-rights-submit-btn" type="submit" class="btn btn-primary mt-3" disabled><i class="far fa-save mr-2"></i> Rechte speichern</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- BLOCK USER MODAL -->
  <div class="modal fade" id="block-user-modal" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Benutzer blockieren</h5>
        </div>
        <div class="modal-body">
          <p id="block-user-message"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
          <button id="block-user-submit-btn" type="button" class="btn btn-warning" data-dismiss="modal">Benutzer blockieren</button>
        </div>
      </div>
    </div>
  </div>

  <!-- DELETE USER MODAL -->
  <div class="modal fade" id="delete-user-modal" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Benutzer löschen</h5>
        </div>
        <div class="modal-body">
          <p id="delete-user-message"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
          <button id="delete-user-submit-btn" type="button" class="btn btn-danger" data-dismiss="modal">in den Papierkorb verschieben</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Shoelace -->
  <script type="module" src="../node_modules/@shoelace-style/shoelace/dist/shoelace/shoelace.esm.js"></script>

  <!-- Bootstrap core JavaScript-->
  <script src="../node_modules/startbootstrap-sb-admin-2/vendor/jquery/jquery.min.js"></script>
  <script src="../node_modules/startbootstrap-sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../node_modules/startbootstrap-sb-admin-2/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../assets/sb-admin/js/sb-admin-2.custom.js"></script>

  <!-- Page level plugins -->
  <script src="../node_modules/startbootstrap-sb-admin-2/vendor/chart.js/Chart.min.js"></script>

  <!-- alert -->
  <script type="text/javascript" src="../assets/js/alert/alert.js"></script>

  <!-- xhr -->
  <script type="text/javascript" src="../assets/js/xhr/xhr.min.js"></script>

  <!-- Custom -->
  <script type="text/javascript" src="./main.js"></script>

</body>

</html>

<?php
  } else {
    header("Location: ../");
  }
} else {
  header("Location: ../");
}
?>