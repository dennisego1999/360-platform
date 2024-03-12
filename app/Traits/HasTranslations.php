<?php

namespace App\Traits;

use Spatie\Translatable\HasTranslations as BaseHasTranslations;

trait HasTranslations
{
    use BaseHasTranslations;

    private bool $replaceTranslations = true;

    public function setReplaceTranslations(bool $replaceTranslations): void
    {
        $this->replaceTranslations = $replaceTranslations;
    }

    /**
     * Get the translatable fields.
     * This is used inside the syncing of models.
     */
    public static function getTranslatableFields(): mixed
    {
        // Create a new instance to access the prop
        return (new self)->translatable;
    }

    /**
     * Convert the model instance to an array.
     * This will ensure the correct translation is returned instead of all translations.
     */
    public function toArray(): array
    {
        // Get the default attributes
        $attributes = parent::toArray();

        // Get the translatable attributes
        $translatableAttributes = $this->getTranslatableAttributes();

        // Return the attributes as-if when disabled
        if (! $this->replaceTranslations) {
            // Loop over the attributes
            foreach ($attributes as $attribute => &$value) {
                // Skip if the attribute is not translatable
                if (! in_array($attribute, $translatableAttributes, true)) {
                    continue;
                }

                // Replace by an empty variable if empty
                if (empty($value)) {
                    $value = [];
                }
            }

            return $attributes;
        }

        // Loop over the attributes which are translatable
        foreach ($translatableAttributes as $field) {
            // Get the base translation for the current or fallback locale
            $translation = $this->getTranslation($field, \App::getLocale());

            // No translation was found
            if (! $translation) {
                // Get the supported locales
                $locales = config('localization.supported-locales');

                // Go through our locales
                foreach ($locales as $locale) {
                    // A translation exists for the current locale
                    if ($translation = $this->getTranslation($field, $locale)) {
                        break; // Avoid searching for locales
                    }
                }
            }

            $attributes[$field] = $translation; // Set the translation for the field
        }

        return $attributes;
    }
}
