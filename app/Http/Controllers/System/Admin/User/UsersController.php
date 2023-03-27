<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Cheslacki
 * Date: 24/03/2023
 * Time: 08:51
 */

namespace App\Http\Controllers\System\Admin\User;

use App\Exceptions\ExceptionValidation;
use App\Helpers\CheckHelper;
use App\Helpers\FormatHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validation\UserController as ValidationUserController;
use App\Models\User\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;

/**
 * Class UsersController
 * @package App\Http\Controllers\System\Admin\User
 */
class UsersController extends Controller
{
    /**
     * @throws Exception
     */
    private function create()
    {
        $this->addDataArray([
            'email_verified_at' => Carbon::now(), /* Provisional */
            'role' => 'admin'
        ]);

        /** @var object $user */
        $user = User::query()->create($this->getDataArray());
        if ($this->setObject($user)) {
            $this->setId($user->id);
        } else {
            throw new Exception(__('Error, create.'));
        }
    }

    /**
     * @throws Exception
     */
    private function update()
    {
        $user = User::query()->find($this->getId());

        if ($user && $user->update($this->getDataArray())) {
            $this->setObject($user);
        } else {
            throw new Exception(__('Error, update.'));
        }
    }

    /**
     * @throws Exception
     */
    private function delete()
    {
        $this->setDataArray(['active' => 'no']);

        if ($this->getId()) {
            if (is_array($this->getId())) {
                $user = User::query()->whereIn('id', $this->getId());
            } else {
                $user = User::query()->where('id', $this->getId());
            }

            if ($user->exists() && $user->update($this->getDataArray())) {
                $this->setObject($user->get());
                $user->delete();
            }
        } else {
            throw new Exception(__('Error, absence id.'));
        }
    }

    /**
     * @param Request $request
     * @throws Exception
     */
    private function save(Request $request)
    {
        $this->setDataArray([
            'name' => CheckHelper::getNotEmpty($request, $this->getModelString(), ['name'], null),
            'email' => CheckHelper::getNotEmpty($request, $this->getModelString(), ['email'], null),
            'active' => CheckHelper::getNotEmpty($request, $this->getModelString(), ['active'], null)
        ]);

        $password = CheckHelper::getNotEmpty($request, $this->getModelString(), ['password'], null);

        if ($password) {
            $this->addDataArray(['password' => bcrypt($password)]);
        }

        if ($this->getId()) {
            $this->update();
        } else {
            $this->create();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getUsers(Request $request)
    {
        $params['filter'] = $request->query('filter');

        $field_name = CheckHelper::getNotEmpty($request, 'filter', ['name'], false);

        $field_active = CheckHelper::getNotEmpty($request, 'filter', ['active'], false);

        $query = User::query()->select(['users.*']);

        if ($field_name && strlen($field_name) >= 3) {
            $query->when($field_name, function ($query, $value) {
                $query->where('users.name', 'LIKE', "%{$value}%");
            });
        }

        if ($field_active) {
            $query->when($field_active, function ($query, $value) {
                if ($value == 'yes' || $value == 'no') {
                    $query->where('users.active', $value);
                }
            });
        }

        $query = $query->paginate(2);

        $params = FormatHelper::arrayToParams($params);

        if (!empty($params)) {
            $query->withPath("users?{$params}");
        }

        $page = 'user.list.users';
        $title = __('title.users');
        $link = __('link.all_users');
        return view('system.admin.index', compact('page', 'title', 'link', 'query'));
    }

    /**
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getUser($id = null)
    {
        $query = null;

        if ($id) {
            $query = User::query()->find($id);
        }
        $page = 'user.form.user';
        $title = __('title.user');
        $link = __('link.user');
        return view('system.admin.index', compact('page', 'title', 'link', 'query'));
    }

    /**
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUser(Request $request, $id = null)
    {
        try {
            $validationUserController = (new ValidationUserController());
            $validationUserController->setModelString('user');
            $this->setModelString('user');

            $this->setId($id);
            $validationUserController->setId($id);

            $response = $validationUserController->validateUser($request, [
                'name',
                'email',
                'active',
                'password'
            ]);

            if (!$response['status']) {
                if (isset($response['errors'])) {
                    $this->addErrorObject($response['errors']);
                } else {
                    throw new Exception($response['error']);
                }
            }

            if ($this->getErrorsObject()) {
                throw new ExceptionValidation(json_encode($this->getErrorsObject()));
            }

            $this->save($request);

            $this->dataReturn['user'] = $this->getObject();

            /** @var object $current_user */
            $current_user = $this->getCurrentUser();
            if ($current_user) {
                $this->dataReturn['route'] = route("{$current_user->role}.users");
            }

            $this->dataResponse = [
                'status' => true,
                'message' => [
                    'title' => __('message.success_title'),
                    'text' => __('message.success_text')
                ],
                'data' => $this->dataReturn
            ];
        } catch (ExceptionValidation  $e) {
            $this->dataResponse = [
                'status' => false,
                'message' => [
                    'title' => __('message.error_title'),
                    'text' => __('message.error_text')
                ],
                'errors' => json_decode($e->getMessage()),
                'code' => $e->getCode()
            ];
        } catch (Exception $e) {
            $this->dataResponse = [
                'status' => false,
                'message' => [
                    'title' => __('message.error_title'),
                    'text' => $e->getMessage()
                ],
                'errors' => '',
                'code' => $e->getCode()
            ];
        } finally {
            return Response::json($this->dataResponse);
        }
    }

    /**
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUser($id = null)
    {
        try {
            $this->setId($id);

            $this->delete();

            $this->dataReturn['user'] = $this->getObject();

            $this->dataResponse = [
                'status' => true,
                'message' => [
                    'title' => __('message.deleted_title'),
                    'text' => __('message.deleted_text')
                ],
                'data' => $this->dataReturn
            ];
        } catch (Exception $e) {
            $this->dataResponse = [
                'status' => false,
                'message' => [
                    'title' => __('message.error_title'),
                    'text' => $e->getMessage()
                ],
                'errors' => '',
                'code' => $e->getCode()
            ];
        } finally {
            return Response::json($this->dataResponse);
        }
    }
}