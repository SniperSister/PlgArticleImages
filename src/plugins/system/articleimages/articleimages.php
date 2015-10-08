<?php
/**
 * @version    %%PLUGINVERSION%%
 * @package    PlgArticleImages
 * @copyright  Copyright (C) 2015 David Jardin - djumla Webentwicklung
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link       http://www.djumla.de
 */

defined('_JEXEC') or die;

/**
 * A plugin to add additional image fields to an Joomla article
 *
 * @since  1.0
 */
class PlgSystemArticleimages extends JPlugin
{
    /**
     * Load the language file on instantiation.
     *
     * @var    boolean
     * @since  1.0
     */
    protected $autoloadLanguage = true;

    /**
     * The language object
     *
     * @var null
     * @since  1.0
     */
    protected $lang = null;

    /**
     * constructor, used to inject the language class for testing purposes
     *
     * @param   object  &$subject  The object to observe
     * @param   array   $config    An optional associative array of configuration settings.
     *                             Recognized key values include 'name', 'group', 'params', 'language'
     *                             (this list is not meant to be comprehensive).
     *
     * @since  1.0
     */
    public function __construct(&$subject, $config = array())
    {
        parent::__construct($subject, $config);

        $this->lang = JFactory::getLanguage();
    }

    /**
     * adds additional fields to the user editing form
     *
     * @param   JForm  $form  The form to be altered.
     *
     * @return  boolean
     *
     * @since   1.0
     */
    public function onContentPrepareForm($form)
    {
        if (!($form instanceof JForm))
        {
            return false;
        }

        // Check we are manipulating a valid form.
        $name = $form->getName();

        if ($name !== "com_content.article")
        {
            return true;
        }

        // Build basic document
        $xml = '<?xml version="1.0" encoding="utf-8"?><form><fields name="images" label="COM_CONTENT_FIELD_IMAGE_OPTIONS">';

        for ($i = 1; $i <= (int) $this->params->get('imagecount', 1); $i++)
        {
            $xml .= $this->getXmlForField($i);
        }

        // Close open tags
        $xml .= '</fields></form>';

        // Add fields to xml
        $form->load($xml);

        return true;
    }

    /**
     * gets the field xml for an additional image fields
     *
     * @param   int  $count  count parameter for the image
     *
     * @return  string
     *
     * @since  1.0
     */
    public function getXmlForField($count)
    {
        $label = $this->lang->_('PLG_ARTICLEIMAGES_ADDITIONAL_IMAGE_LABEL') . $count;

        return '<field
                    name="image_spacer' . $count . '"
                    type="spacer"
                    hr="true"
                    />
                <field
                    name="image_additional' . $count . '"
                    type="media"
                    label="' . $label . '" />
                <field
                    name="float_additional' . $count . '"
                    type="list"
                    label="COM_CONTENT_FLOAT_LABEL"
                    description="COM_CONTENT_FLOAT_DESC">
                        <option value="">JGLOBAL_USE_GLOBAL</option>
                        <option value="right">COM_CONTENT_RIGHT</option>
                        <option value="left">COM_CONTENT_LEFT</option>
                        <option value="none">COM_CONTENT_NONE</option>
                </field>
                <field name="image_additional' . $count . '_alt"
                    type="text"
                    label="COM_CONTENT_FIELD_IMAGE_ALT_LABEL"
                    description="COM_CONTENT_FIELD_IMAGE_ALT_DESC"
                    size="20"/>
                <field name="image_additional' . $count . '_caption"
                    type="text"
                    label="COM_CONTENT_FIELD_IMAGE_CAPTION_LABEL"
                    description="COM_CONTENT_FIELD_IMAGE_CAPTION_DESC"
                    size="20"/>';
    }

    /**
     * set a custom JLanguage object for testing purposes
     *
     * @param   JLanguage  $language  language object
     *
     * @return true
     *
     * @since  1.0
     */
    public function setLanguageService(JLanguage $language)
    {
        $this->lang = $language;

        return true;
    }
}
