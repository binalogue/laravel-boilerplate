import Vuelidate from 'vuelidate';
import VuelidateErrorExtractor from 'vuelidate-error-extractor';
import BaseFormGroup from 'components/BaseFormGroup';

export default {
  install(Vue) {
    Vue.use(Vuelidate);
    Vue.use(VuelidateErrorExtractor, {
      template: BaseFormGroup,
      name: 'BaseFormGroup',
      messages: {
        email: 'validation.vuelidate.email',
        maxLength: 'validation.vuelidate.max',
        required: 'validation.vuelidate.required',
      },
    });
  },
};
