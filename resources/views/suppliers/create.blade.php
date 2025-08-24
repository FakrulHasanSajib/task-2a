<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supplier Create</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Supplier Create</h1>
        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-700">Supplier Information</h2>
                
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name<span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" placeholder="Enter Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    @error('name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="mobile_no" class="block text-gray-700 text-sm font-bold mb-2">Mobile No.<span class="text-red-500">*</span></label>
                    <input type="text" id="mobile_no" name="mobile_no" placeholder="Enter Mobile No." class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    @error('mobile_no')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter Email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address</label>
                    <textarea id="address" name="address" placeholder="Enter address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Status<span class="text-red-500">*</span></label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="1" checked class="form-radio text-purple-600">
                            <span class="ml-2 text-gray-700">Active</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="0" class="form-radio text-gray-500">
                            <span class="ml-2 text-gray-700">Inactive</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-6">
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Save
                    </button>
                    <a href="{{ route('suppliers.index') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>