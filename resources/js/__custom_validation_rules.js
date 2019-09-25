import { extend } from 'vee-validate';

export const alpha_space_dash = extend('alpha_space_dash', {
   validate: value => {
      return value.match(/[^\w\- ]+/g) === null;
   }
});