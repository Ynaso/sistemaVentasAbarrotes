<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePresentacioneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //esta ruta esta en el edit, se crea esta variable para poder acceder a sus atributos despues atravez del formulario de Actualizacion
        $presentacione = $this->route('presentacione');
        //el nombre debe coincidir(osea la variable, de la ruta en edit con todas las variables en Update tambien, y en los formularios para que funcione correctamente el codigo)
        $caracteristicaId = $presentacione->caracteristica->id;
        return [
            'nombre' => 'required|max:60|unique:caracteristicas,nombre,'.$caracteristicaId,
            'descripcion' => 'nullable|max:255'
        ];
    }
}
