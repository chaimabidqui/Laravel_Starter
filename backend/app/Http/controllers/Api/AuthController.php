<?php

namespace App\Http\Controllers\Api;

use App\Models\Acl;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\ReferenceService;
use NunoMaduro\Collision\Provider;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Validator;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers\Api
 */
class AuthController extends BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->input('email'))->first();
        if (empty($user)) {
            return response()->json(['message' => 'The email is incorrect', 'status' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }
        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json(['message' => 'The password is incorrect', 'status' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }
        // if ($user->status === 'inProgress') {
        //     return response()->json(['message' => 'Your account has not been activated yet!', 'status' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        // }
        if ($user->status === 'deactivated') {
            return response()->json(['message' => 'Your account has been deactivated, contact support for more information', 'status' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }
        // if ($user->email_verified_at == null) {
        //     return response()->json(['message' => 'Your account has not been verified yet! Check your email for verification', 'status' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        // }

        $user->token = $user->createToken('center')->plainTextToken;

        return response()->json([
            'message' => 'Success connection',
            'api_token'    => $user->token,
            'data'    => $user,
            'status'  => Response::HTTP_OK
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();
        return response()->json([
            'message' => 'Successfully logged out',
            'status'  => Response::HTTP_OK,
        ]);
    }

    public function verifyToken(Request $request)
    {
        // abort_if($request->user()-auth(), Response::HTTP_FORBIDDEN);
        return response()->json([
            'message' => 'Success connection',
            'api_token'    => $request->bearerToken(),
            'data'    => $request->user(),
            'status'  => Response::HTTP_OK
        ]);
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        // if($validator->fails()){
        //     return response()->json([
        //         'message' => 'Validation Error',
        //         'data'    => $validator->errors(),
        //         'status'  => Response::HTTP_NOT_FOUND
        //     ]);
        // }

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' =>'activated'
        ]);
        // $user->syncRoles(Role::findByName(Acl::ROLE_TEACHER), Role::findByName(Acl::ROLE_STUDENT));
        $user->token = $user->createToken('Center')->plainTextToken;

        return response()->json([
            'message' => 'User register successfully',
            'api_token'    => $user->token,
            'data'    =>  $user,
            'status'  => Response::HTTP_OK
        ]);
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param $provider
     * @return JsonResponse
     */
    // public function redirectToProvider($provider)
    // {
    //     $validated = $this->validateProvider($provider);
    //     if (!is_null($validated)) {
    //         return $validated;
    //     }

    //     // return Socialite::driver($provider)->stateless()->redirect();
    // }

    /**
     * Obtain the user information from Provider.
     *
     * @param $provider
     * @return JsonResponse
     */
    // public function handleProviderCallback($provider)
    // {
    //     $validated = $this->validateProvider($provider);
    //     if (!is_null($validated)) {
    //         return $validated;
    //     }
    //     try {
    //         $user = Socialite::driver($provider)->stateless()->user();
    //         $searchUser = Provider::where('provider_id', $user->id)->first();
    //         if($searchUser){
    //             $userCreated = User::where('email', $user->email)->first();
    //             $userCreated->token = $userCreated->createToken('Center')->plainTextToken;
    //             return response()->json([
    //                 'message' => 'Success connection',
    //                 'api_token'    => $userCreated->token,
    //                 'data'    => new AuthResource($userCreated),
    //                 'status'  => Response::HTTP_OK
    //             ]);
    //         }else{
    //             $checkUser = User::where('email', $user->email)->first();
    //             if($checkUser){
    //                 $checkUser->providers()->updateOrCreate(
    //                     [
    //                         'provider' => $provider,
    //                         'provider_id' => $user->id,
    //                         'avatar' => $user->avatar
    //                     ]
    //                 );
    //                 $token = $checkUser->createToken('Center')->plainTextToken;
    //                 return response()->json([
    //                     'message' => 'Success connection',
    //                     'api_token'    => $token,
    //                     'data'    => new AuthResource($checkUser),
    //                     'status'  => Response::HTTP_OK
    //                 ]);
    //             }else{
    //                 $userCreated = User::firstOrCreate(
    //                     [
    //                         'email' => $user->email,
    //                         'email_verified_at' => now(),
    //                         'socialname' => $user->name ?? $user->nickname,
    //                         'status' =>'activated',
    //                         'password' => Hash::make('12345678'),
    //                         'avatar' => $user->avatar
    //                     ]
    //                 );
    //                 $userCreated->providers()->updateOrCreate(
    //                     [
    //                         'provider' => $provider,
    //                         'provider_id' => $user->id,
    //                         'avatar' => $user->avatar
    //                     ]
    //                 );
    //                 // $userCreated->syncRoles(Role::findByName(Acl::ROLE_TEACHER), Role::findByName(Acl::ROLE_STUDENT));
    //                 $token = $userCreated->createToken('Center')->plainTextToken;
    //                 return response()->json([
    //                     'message' => 'Success connection',
    //                     'api_token'    => $token,
    //                     'data'    => new AuthResource($userCreated),
    //                     'status'  => Response::HTTP_OK
    //                 ]);
    //             }
    //         }
    //     } catch (ClientException $exception) {
    //         return response()->json(['error' => 'Invalid credentials provided.'], 422);
    //     }
    // }

    /**
     * @param $provider
     * @return JsonResponse
     */
    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['facebook', 'github', 'google', 'linkedin', 'apple', 'instagram', 'twitter'])) {
            return response()->json(['error' => 'Please login using facebook, github, google, instagram'], 422);
        }
    }
}