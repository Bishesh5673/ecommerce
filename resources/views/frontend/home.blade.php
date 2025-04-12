<x-frontend-layout>
    <section>
        <div class="container py-10 text-center space-y-4">
            <h1 class="text-3xl font-bold">
                Register Your Business
            </h1>
            <p>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ad dolorum corporis perspiciatis possimus
                repudiandae, suscipit nesciunt laboriosam aut eaque eveniet sit explicabo, perferendis autem dolorem
                facilis obcaecati maxime incidunt blanditiis.
            </p>
            <div>
                <button data-modal-target="request-modal" data-modal-toggle="request-modal" type="button"
                    class="btn-primary cursor-pointer">Send Request</button>
            </div>

            <!-- Main modal -->
            <div id="request-modal" tabindex="-1" aria-hidden="true"
                class="hidden text-left overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow-sm">
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                            <h3>
                                SEND REQUEST
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                data-modal-hide="request-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4">
                            <form action="{{ route('seller_store') }}" method="post">
                                @csrf
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="name" class="block mb-2 text-sm font-medium">Your
                                            Name</label>
                                        <input type="text" name="name" id="name" class="w-full" />
                                    </div>

                                    <div>
                                        <label for="email"
                                            class="block mb-2 text-sm font-medium">Your
                                            Email</label>
                                        <input type="email" name="email" id="email" class="w-full" />
                                    </div>

                                    <div>
                                        <label for="contact_number"
                                            class="block mb-2 text-sm font-medium">Your
                                            COntact Number</label>
                                        <input type="text" name="contact_number" id="contact_number" class="w-full" />
                                    </div>

                                    <div>
                                        <label for="address"
                                            class="block mb-2 text-sm font-medium">Your
                                            Shop Address</label>
                                        <input type="text" name="address" id="address" class="w-full" />
                                    </div>

                                    <div>
                                        <label for="pan_no"
                                            class="block mb-2 text-sm font-medium">PAN NO</label>
                                        <input type="text" name="pan_no" id="pan_no" class="w-full" />
                                    </div>

                                    <div>
                                        <label for="reg_no"
                                            class="block mb-2 text-sm font-medium">Reg NO</label>
                                        <input type="text" name="reg_no" id="reg_no" class="w-full" />
                                    </div>

                                    <div class="col-span-2">
                                        <button type="submit" class="btn-primary w-full">Send Request</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section>
        <div class="container py-10">
            <h1 class="text-3xl font-bold text-center">
                Get Featured Products with limited time offer!
            </h1>

            <div class="grid grid-cols-3 gap-4 py-5">

                @foreach ($offer_products as $product)
                   <x-product-card :product="$product" />
                @endforeach

            </div>
        </div>
    </section>

    <section class="">
        <div class="container py-10 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-center">
                    About Us
                </h1>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, exercitationem dolorum. Quaerat,
                    quia. Non hic ea incidunt officia ratione repudiandae voluptates ut sit dolor. Delectus ducimus
                    laborum at velit sunt?
                </p>

                <a href="{{ route('about') }}">read more</a>
            </div>

            <img src="https://media.istockphoto.com/id/1221653457/photo/close-up-of-a-touchscreen-social-media-concept.jpg?s=612x612&w=0&k=20&c=thcgiLGWFoRNMrMiDXDGUGPy50i9jhXhiHSy-vokyqI="
                alt="">
    </section>
</x-frontend-layout>
