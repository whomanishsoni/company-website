@extends('layouts.frontend')

@section('title', 'Join Now')

@section('content')
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-4 text-center text-gray-800">Join Now</h1>
            <p class="text-xl mb-8 text-center text-gray-600">We're always looking for talented individuals to join our team.
            </p>

            <!-- Custom Alert Container -->
            <div id="custom-alert"
                class="hidden fixed top-4 right-4 p-4 rounded-lg shadow-lg bg-red-100 border border-red-400 text-red-700">
                <span id="alert-message"></span>
                <button onclick="hideAlert()" class="ml-4 text-red-700 hover:text-red-900">
                    &times;
                </button>
            </div>

            <!-- Join Form -->
            <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
                <form id="create-member-form" action="{{ route('join.store') }}" method="POST">
                    @csrf

                    <!-- Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required>
                        @error('name')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Father's Name -->
                    <div class="mb-6">
                        <label for="father_name" class="block text-sm font-medium text-gray-700">
                            Father's Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="father_name" id="father_name" value="{{ old('father_name') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required>
                        @error('father_name')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div class="mb-6">
                        <label for="dob" class="block text-sm font-medium text-gray-700">
                            Date of Birth <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="dob" id="dob" value="{{ old('dob') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required>
                        @error('dob')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- WhatsApp Number -->
                    <div class="mb-6">
                        <label for="whatsapp" class="block text-sm font-medium text-gray-700">
                            WhatsApp Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required>
                        @error('whatsapp')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Alternate Number -->
                    <div class="mb-6">
                        <label for="alt_no" class="block text-sm font-medium text-gray-700">
                            Alternate Number
                        </label>
                        <input type="text" name="alt_no" id="alt_no" value="{{ old('alt_no') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('alt_no')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required>
                        @error('email')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="mb-6">
                        <label for="address" class="block text-sm font-medium text-gray-700">
                            Address <span class="text-red-500">*</span>
                        </label>
                        <textarea name="address" id="address"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required>{{ old('address') }}</textarea>
                        @error('address')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- City -->
                    <div class="mb-6">
                        <label for="city" class="block text-sm font-medium text-gray-700">
                            City <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required>
                        @error('city')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- State -->
                    <div class="mb-6">
                        <label for="state_id" class="block text-sm font-medium text-gray-700">
                            State <span class="text-red-500">*</span>
                        </label>
                        <select name="state_id" id="state_id"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="">Select State</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                    {{ $state->name }}</option>
                            @endforeach
                        </select>
                        @error('state_id')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Pincode -->
                    <div class="mb-6">
                        <label for="pincode" class="block text-sm font-medium text-gray-700">
                            Pincode <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="pincode" id="pincode" value="{{ old('pincode') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required>
                        @error('pincode')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Business -->
                    <div class="mb-6">
                        <label for="business" class="block text-sm font-medium text-gray-700">
                            Business
                        </label>
                        <select name="business" id="business"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Business</option>
                            <option value="IT" {{ old('business') == 'IT' ? 'selected' : '' }}>IT</option>
                            <option value="Retail" {{ old('business') == 'Retail' ? 'selected' : '' }}>Retail</option>
                            <option value="Healthcare" {{ old('business') == 'Healthcare' ? 'selected' : '' }}>Healthcare
                            </option>
                            <option value="Education" {{ old('business') == 'Education' ? 'selected' : '' }}>Education
                            </option>
                            <option value="Other" {{ old('business') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('business')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Blood Group -->
                    <div class="mb-6">
                        <label for="blood_group" class="block text-sm font-medium text-gray-700">
                            Blood Group
                        </label>
                        <select name="blood_group" id="blood_group"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Blood Group</option>
                            <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                            <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                        </select>
                        @error('blood_group')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Inspirer -->
                    <div class="mb-6">
                        <label for="inspirer" class="block text-sm font-medium text-gray-700">
                            Inspirer
                        </label>
                        <input type="text" name="inspirer" id="inspirer" value="{{ old('inspirer') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('inspirer')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Cooperation Field -->
                    <div class="mb-6">
                        <label for="cooperation_field" class="block text-sm font-medium text-gray-700">
                            Cooperation Field
                        </label>
                        <input type="text" name="cooperation_field" id="cooperation_field"
                            value="{{ old('cooperation_field') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('cooperation_field')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-blue-700 transition duration-300">
                            Apply Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            // Function to show custom alert
            function showAlert(message, type = 'error') {
                const alertDiv = document.getElementById('custom-alert');
                const alertMessage = document.getElementById('alert-message');

                // Set alert message
                alertMessage.textContent = message;

                // Set alert color based on type
                if (type === 'success') {
                    alertDiv.classList.remove('bg-red-100', 'border-red-400', 'text-red-700');
                    alertDiv.classList.add('bg-green-100', 'border-green-400', 'text-green-700');
                } else {
                    alertDiv.classList.remove('bg-green-100', 'border-green-400', 'text-green-700');
                    alertDiv.classList.add('bg-red-100', 'border-red-400', 'text-red-700');
                }

                // Show alert
                alertDiv.classList.remove('hidden');
            }

            // Function to hide custom alert
            function hideAlert() {
                document.getElementById('custom-alert').classList.add('hidden');
            }

            $(document).ready(function() {
                $('#create-member-form').on('submit', function(e) {
                    let isValid = true;
                    let errorMessage = '';

                    // Validate WhatsApp number
                    var whatsappNumber = $('#whatsapp').val();
                    if (whatsappNumber.length !== 10 || isNaN(whatsappNumber)) {
                        isValid = false;
                        errorMessage += 'WhatsApp number must be exactly 10 digits long.\n';
                    }

                    // Validate Email
                    var email = $('#email').val();
                    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        isValid = false;
                        errorMessage += 'Please enter a valid email address.\n';
                    }

                    // Validate Pincode
                    var pincode = $('#pincode').val();
                    if (pincode.length != 6 || isNaN(pincode)) {
                        isValid = false;
                        errorMessage += 'Pincode must be exactly 6 digits.\n';
                    }

                    // If validation fails, prevent form submission and show error messages
                    if (!isValid) {
                        e.preventDefault();
                        showAlert(errorMessage); // Show error message using custom alert
                        return false;
                    }

                    // If all checks pass, show success message
                    showAlert('Form submitted successfully!', 'success');
                });
            });
        </script>
    @endpush
@endsection
