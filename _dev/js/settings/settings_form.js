'use strict';

const $ = window.$;
/**
import Bloodhound from 'typeahead.js';
import 'typeahead.js/dist/typeahead.jquery';
import 'typeahead.js/dist/bloodhound.min';
*/
import TranslatableInput from '../../../../../admin202/themes/new-theme/js/components/translatable-input';
import TranslatableField from '../../../../../admin202/themes/new-theme/js/components/translatable-field';
import FormSubmitButton from '../../../../../admin202/themes/new-theme/js/components/form-submit-button';
import ChoiceTree from '../../../../../admin202/themes/new-theme/js/components/form/choice-tree';
import GeneratableInput from '../../../../../admin202/themes/new-theme/js/components/generatable-input';
import TextWithLengthCounter from '../../../../../admin202/themes/new-theme/js/components/form/text-with-length-counter';
import TextWithRecommandedLength from '../../../../../admin202/themes/new-theme/js/components/form/text-with-recommended-length-counter';
/*import productSearchAutocomplete from '../../../../../admin202/themes/new-theme/js/product-page/product-search-autocomplete';*/

$(() => {
    const translatorInput = new TranslatableInput();
    new TranslatableField();
    new FormSubmitButton();
    new ChoiceTree('#form_settings_CHECKBOFORM_CATEGORYTREE');
    new ChoiceTree('#form_settings_CHECKBOFORM_SHOPCHOICETREE');

    const generatableInput = new GeneratableInput();
    generatableInput.attachOn('.js-generator-btn');
    /*  productSearchAutocomplete(); */

  new TextWithLengthCounter();
  //new TextWithRecommendedLengthCounter();
});
