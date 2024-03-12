<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Fortify;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request, $id, string $hash)
    {
        $user = User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return $request->wantsJson()
                ? new JsonResponse('', 401)
                : redirect()->intended(Fortify::redirects('email-verification').'?verified=0', 401);
        }

        if ($user->hasVerifiedEmail()) {
            return $request->wantsJson()
                ? new JsonResponse('', 204)
                : redirect()->intended(Fortify::redirects('email-verification').'?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return $request->wantsJson()
            ? new JsonResponse('', 202)
            : redirect()->intended(Fortify::redirects('email-verification').'?verified=1');
    }
}
