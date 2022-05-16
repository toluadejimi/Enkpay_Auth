<x-layouts.html>
    <div  class="bg-white dark:bg-gray-900 h-full">
        <div class="mx-auto flex justify-center md:items-center relative md:h-full">
            <div class="hidden md:block absolute top-0 right-0 pt-2 mr-4">
                <x-icon-auth-dotted
                    class="text-gray-300"
                    width="200"
                    height="144"
                />
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md space-y-6">
                <div class="flex justify-center items-center">
                    {{--<x-misc.logo/>--}}
                </div>

                {{ $slot ?? null }}
            </div>

            <div class="hidden md:block absolute bottom-0 left-0 pb-2 md:ml-4">
                <x-icon-auth-dotted
                    class="text-gray-300"
                    width="200"
                    height="144"
                />
            </div>
        </div>
    </div>
</x-layouts.html>
