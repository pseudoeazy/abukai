<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "" ?></title>

    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/tailwindcss">
        @layer utilities {
      
      .content-height{
        min-height:70vh;
      }

    iframe {
      border: none;
      width: 400px;
    }
    #keys {
      min-height: 400px;
      padding: 4px;
    }
    .frame-container {
      display: flex;
      flex-direction: column;
    }
    }
  </style>
</head>

<body>
    <header class="header-height">
        <div class=" w-full max-w-7xl">
            <div class="flex flex-col max-w-screen-xl p-5 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
                <div class="flex flex-row items-center justify-between lg:justify-start">
                    <a class="text-lg font-bold tracking-tighter text-blue-600 transition duration-500 ease-in-out transform tracking-relaxed lg:pr-8" href="#"> ABUKAI </a>

                </div>
                <nav class="flex-col flex-grow flex md:justify-start md:flex-row">
                    <ul class="space-y-3 list-none lg:space-y-0 lg:items-center lg:inline-flex">
                        <li>
                            <a href="index.php" class="px-2 lg:px-6 py-3 text-sm border-b-2 border-transparent hover:border-blue-600 leading-[22px] md:px-3 text-gray-500 hover:text-blue-500"> Customer Information Entry Form
                            </a>
                        </li>
                        <li>
                            <a href="index.php?route=customer/review" class="px-2 lg:px-6 py-3 text-sm border-b-2 border-transparent leading-[22px] md:px-3 text-gray-500 hover:text-blue-500 hover:border-blue-600"> Customer Information Review </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="content-height">
        <?= $output ?? ""; ?>
    </main>
    <footer class="bg-white" aria-labelledby="footer-heading">
        <h2 id="footer-heading" class="sr-only">Footer</h2>

        <div class="w-full py-12 mx-auto bg-gray-50 sm:px-6 lg:px-16">
            <div class="flex flex-wrap items-baseline justify-center">
                <span class="mt-2 text-sm font-light text-gray-500">
                    Copyright &copy; <?= date('Y'); ?>
                    <a href="#" class="mx-2 text-wickedblue hover:text-gray-500" rel="noopener noreferrer">AbukaiTest</a>.
                </span>
            </div>
        </div>
    </footer>

</body>

</html>