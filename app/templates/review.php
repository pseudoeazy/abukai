<div class="grid  grid-cols-1 lg:grid-cols-2">
    <section class="p-8 lg:p-2">
        <div class="flex justify-center mb-2">
            <form name="review" id="review" class=" w-full md:w-1/2 ">
                <div class="grid gap-6 mb-6">
                    <input type="hidden" name="route" value="customer/review">
                    <div class="grid gap-6 mb-6">
                        <div class="mb-6">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email address</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 " placeholder="john.doe@company.com" required>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="flex space-x-1 justify-center items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <span>Submit</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="flex justify-center">
            <?php
            if (isset($_GET['email'])) {
                if (!empty($customer)) {
                    $customer = $customer[0];
            ?>
                    <div class="w-full md:w-1/2 ">


                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <div>
                                <div>
                                    <img class="h-auto max-w-full rounded-lg" src="<?= htmlspecialchars(
                                                                                        $customer->picture,
                                                                                        ENT_QUOTES,
                                                                                        'UTF-8'
                                                                                    ) ?? "" ?>" alt="">
                                </div>
                            </div>
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

                                <tbody>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            First Name
                                        </th>
                                        <td class="px-6 py-4">

                                            <?= htmlspecialchars(
                                                $customer->firstname,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )  ?? "" ?>
                                        </td>

                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Last Name
                                        </th>
                                        <td class="px-6 py-4">
                                            <?= htmlspecialchars(
                                                $customer->lastname,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )  ?? "" ?>
                                        </td>

                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Email
                                        </th>
                                        <td class="px-6 py-4">
                                            <?= htmlspecialchars(
                                                $customer->email,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )  ?? "" ?>
                                        </td>

                                    </tr>
                                    <tr class="bg-white dark:bg-gray-800">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            City
                                        </th>
                                        <td class="px-6 py-4">
                                            <?= htmlspecialchars(
                                                $customer->city,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )  ?? "" ?>
                                        </td>

                                    </tr>
                                    <tr class="bg-white dark:bg-gray-800">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Country
                                        </th>
                                        <td class="px-6 py-4">
                                            <?= htmlspecialchars(
                                                $customer->country,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )  ?? "" ?>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

            <?php

                } else {
                    echo '<div class="w-full md:w-1/2  text-red-500 text-center font-semibold">Customer Not Found</div>';
                }
            }
            ?>

        </div>
    </section>
    <section>
        <div class="frame-container flex flex-col items-center">
            <iframe id="display" title="display" src="app/assets/display.html"> </iframe>

            <iframe title="keys" id="keys" src="app/assets/keys.html"> </iframe>
        </div>
    </section>
</div>