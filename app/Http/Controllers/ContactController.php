<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Log;

    class ContactController extends Controller
    {
        public function submit(Request $request)
        {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:150',
                'phone' => 'nullable|string|max:25',
                'message' => 'required|string|max:2000',
            ]);

            $token = config('services.whatsapp.token');
            $phoneNumberId = config('services.whatsapp.phone_number_id');
            $recipient = config('services.whatsapp.recipient');
            $version = config('services.whatsapp.version');

            if (!$token || !$phoneNumberId || !$recipient || !$version) {
                Log::error('WhatsApp notification configuration is missing.');

                return back()->with(
                    'error',
                    'Configuration error. Please try again later.'
                );
            }

            try {
                $response = Http::withToken($token)
                    ->acceptJson()
                    ->timeout(20)
                    ->post(
                        "https://graph.facebook.com/{$version}/{$phoneNumberId}/messages",
                        [
                            'messaging_product' => 'whatsapp',
                            'to' => $recipient,
                            'type' => 'template',
                            'template' => [
                                'name' => 'contact_form_alert',
                                'language' => [
                                    'code' => 'en_US',
                                ],
                                'components' => [
                                    [
                                        'type' => 'body',
                                        'parameters' => [
                                            [
                                                'type' => 'text',
                                                'text' => $validated['name'],
                                            ],
                                            [
                                                'type' => 'text',
                                                'text' => $validated['email'],
                                            ],
                                            [
                                                'type' => 'text',
                                                'text' => $validated['phone'] ?: 'Not provided',
                                            ],
                                            [
                                                'type' => 'text',
                                                'text' => $validated['message'],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ]
                    );

                if (!$response->successful()) {
                    Log::error('WhatsApp API request failed.', [
                        'status' => $response->status(),
                        'response' => $response->json(),
                    ]);

                    return back()->with(
                        'error',
                        'Your message could not be sent. Please try again later.'
                    );
                }

                return back()->with(
                    'success',
                    'Thank you! Your enquiry has been submitted.'
                );

            } catch (\Throwable $e) {
                Log::error('WhatsApp notification exception.', [
                    'error' => $e->getMessage(),
                ]);

                return back()->with(
                    'error',
                    'Something went wrong. Please try again later.'
                );
            }
        }
    }

?>

