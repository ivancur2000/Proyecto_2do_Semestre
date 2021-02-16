//validacion de campos de texto
function validar(e) { 
    tecla = (document.all) ? e.keyCode : e.which; 
    if (tecla==8) return true; 
    patron =/[A-Za-z\s]/; //solo letras
    te = String.fromCharCode(tecla); 
    return patron.test(te); 
}
// validacion sol numeros
function soloNumeros(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " 1234567890";
    especiales = " áéíóúabcdefghijklmnñopqrstuvwxyz";

    tecla_especial = false
    for(var i in especiales) {
        if(key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if(letras.indexOf(tecla) == -1 && !tecla_especial)
        return false;
}
//validadion con jquery valdate
$(document).ready(function () {
    $.validator.setDefaults({
       /*  submitHandler: function () 
        {
        alert( "Form successful submitted!" );
        } */
    });
    $('#formulario').validate({
        rules: {
            tb_name: {
                required: true, 
                minlength: 3
            },
            tb_app: {
                required: true,
                minlength: 3
            },
            tb_apm: {
                required: true,
                minlength: 3
            },
            tb_email: {
                required: true,
                email: true,
            },
            tb_ci: {
                required: true, 
                minlength: 8,
            },
            cb_cargo: {
                required: true
            },
            dt_ing: {
                required: true
            },
            dt_naci: {
                required: true
            },
            genero: {
                required: true
            },
            tb_cel: {
                required: true,
                minlength: 8
            },
            tb_cel2: {
                minlength: 8
            },
            tb_dir: {
                required: true,
            },
            tb_salario: {
                required: true
            },
            imagen: {
                required: true
            },
            tb_pass: {
                required: true,
                minlength: 8
            }, 
            tb_pass2: {
                required: true,
                minlength: 8
            }, 
            tb_confirm: {
                required: true,
                minlength: 8
            },
            tb_cod: {
                required: true,
                minlength: 3,
                maxlength: 3,
            },
            tb_tam: {
                required: true,
                maxlength: 5,
            },
            tb_cuartos: {
                required: true,
                maxlength: 3,
            },
            //nuevo formulario
            tb_duracion: {
                required: true,
                maxlength: 3,
            },
            cb_pago: {
                required: true,
            },
            tb_interes: {
                required: true,
                maxlength: 3,
            },
            tb_desc: {
                required: true,
                minlength: 5,
            },
            tb_fech: {
                required: true,
            },
            tb_pisos: {
                required: true,
                maxlength: 2,
            },
            tb_zona: {
                required: true,
                minlength: 3,
            },
            tb_calle: {
                required: true,
                maxlength: 15,
            },
            tb_puerta: {
                required: true,
            },
            tb_ref: {
                required: true,
                minlength: 5,
            },
            tb_stock: {
                required: true,
                maxlength: 3,
            },
            cb_estado: {
                required: true,
            },
            busqueda: {
                required: true,
            },
            tb_us: {
                required: true,
            },
        },
        messages: {
            tb_name: {
                required: "Este campo es obligatorio.",
                minlength: "Este campo requiere minimamente 3 caracteres"
            },
            tb_app: {
                required: "Este campo es obligatorio.",
                minlength: "Este campo requiere minimamente 3 caracteres"
            },
            tb_apm: {
                required: "Este campo es obligatorio.",
                minlength: "Este campo requiere minimamente 3 caracteres"
            },
            tb_email: {
                required: "Este campo es obligatorio.",
                email: "Debe introducir un correo valido"
            },
            tb_ci: {
                required: "Este campo es obligatorio.",
                minlength: "Este campo requiere minimamente 8 carateres"
            },
            cb_cargo: {
                required: "Debe seleccionar un campo obligatoriamente.",
            },
            dt_ing: {
                required: "Este campo es obligatorio."
            },
            dt_naci: {
                required: "Este campo es obligatorio."
            },
            genero: {
                required: "Debe seleccionar un campo obligatoriamente.",
            },
            tb_cel: {
                required: "Este campo es obligatorio.",
                minlength: "Este campo requiere minimamente 8 caracteres"
            },
            tb_cel2: {
                minlength: "Este campo requiere minimamente 8 caracteres"
            },
            tb_dir: {
                required: "Este campo es obligatorio.",
            },
            tb_salario: {
                required: "Este campo es obligatorio."
            },
            imagen: {
                required: "Debe subir una imagen de perfil."
            },
            tb_pass: {
                required: "Este campo es obligatorio.",
                minlength: "Este campo requiere minimamente 8 caracteres"
            }, 
            tb_confirm: {
                required: "Este campo es obligatorio.",
                minlength: "Este campo requiere minimamente 8 caracteres"
            },
            tb_cod: {
                required: "Este Campo es obligatorio.",
                minlength: "Este campo requiere minimamente 3 caracteres",
                maxlength: "Este campo no puede tener mas de 3 caracteres",
            },
            tb_tam: {
                required: "Este campo es obligatorio.",
                maxlength: "Este campo no debe tener mas de 5 caracteres",
            },
            tb_cuartos: {
                required: "Este campo es obligatorio",
                maxlength: "Este campo no puede tener mas de 3 caracteres",
            },
            tb_duracion: {
                required: "Este campo es obligatorio",
                maxlength: "Este campo no puede tener mas de 3 caracteres",
            },
            cb_pago: {
                required: "Este campo es obligatorio",
            },
            tb_interes: {
                required: "Este campo es obligatorio",
                maxlength: "Este campo no puede tener mas de 3 caracteres",
            },
            tb_desc: {
                required: "Este campo es obligatorio",
                minlength: "Este campo requiere minimamente 5 caracteres",
            },
            tb_desc: {
                required: "Este campo es obligatorio",
                minlength: "Este campo requiere minimamente 5 caracteres",
            },
            tb_fech: {
                required: "Este campo es obligatorio",
            },
            tb_pisos: {
                required: "Este campo es obligatorio",
                maxlength: "Este campo no puede tener mas de 2 caracteres",
            },
            tb_zona: {
                required: "Este campo es obligatorio",
                minlength: "Este campo requiere minimamente 3 caracteres",
            },
            tb_calle: {
                required: "Este campo es obligatorio",
                maxlength: "Este campo no puede tener mas de 15 caracteres",
            },
            tb_puerta: {
                required: "Este campo es obligatorio",
            },
            tb_ref: {
                required: "Este campo es obligatorio",
                minlength: "Este campo requiere minimamente 5 caracteres",
            },
            tb_stock: {
                required: "Este campo es obligatorio",
                maxlength: "Este campo requiere minimamente 3 caracteres",
            },
            cb_estado: {
                required: "Este campo es obligatorio",
            },
            busqueda: {
                required: "Debe introducir al menor un dato de busqueda",
            },
            tb_us: {
                required: "Debe introducir su usuario",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
            highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
            unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});
//este es el codigo de la vida!!!!!!!!!!!

  
  
