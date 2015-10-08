<?php
/**
 * @version    1.0.0
 * @package    PlgArticleImages
 * @copyright  Copyright (C) 2015 David Jardin - djumla Webentwicklung
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link       http://www.djumla.de
 */

/**
 * Class ArticleimagesTest
 *
 * @since  1.0.0
 */
class ArticleimagesTest extends PHPUnit_Framework_TestCase
{
    public $object;

    /**
     * set up mock objects
     *
     * @return void
     */
    public function setUp()
    {
        $object = $this->getMockBuilder('PlgSystemArticleimages')
            ->setMethods(array('getXmlForField'))
            ->disableOriginalConstructor()
            ->getMock();


        $this->object = $object;
    }

    /**
     * test if generated xml is correct
     *
     * @return void
     */
    public function testXmlForFieldsIsGeneratedCorrectly()
    {
        $expectedXml = '<field
                    name="image_spacer1"
                    type="spacer"
                    hr="true"
                    />
                <field
                    name="image_additional1"
                    type="media"
                    label="TestingString1" />
                <field
                    name="float_additional1"
                    type="list"
                    label="COM_CONTENT_FLOAT_LABEL"
                    description="COM_CONTENT_FLOAT_DESC">
                        <option value="">JGLOBAL_USE_GLOBAL</option>
                        <option value="right">COM_CONTENT_RIGHT</option>
                        <option value="left">COM_CONTENT_LEFT</option>
                        <option value="none">COM_CONTENT_NONE</option>
                </field>
                <field name="image_additional1_alt"
                    type="text"
                    label="COM_CONTENT_FIELD_IMAGE_ALT_LABEL"
                    description="COM_CONTENT_FIELD_IMAGE_ALT_DESC"
                    size="20"/>
                <field name="image_additional1_caption"
                    type="text"
                    label="COM_CONTENT_FIELD_IMAGE_CAPTION_LABEL"
                    description="COM_CONTENT_FIELD_IMAGE_CAPTION_DESC"
                    size="20"/>';

        // Prepare mocks
        $object = $this->getMockBuilder('PlgSystemArticleimages')
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock();

        $languageMock = $this->getMockBuilder('JLanguage')->disableOriginalConstructor()->getMock();
        $languageMock->method('_')->with('PLG_ARTICLEIMAGES_ADDITIONAL_IMAGE_LABEL')->willReturn('TestingString');

        $object->setLanguageService($languageMock);

        // Trigger test
        $this->assertSame($expectedXml, $object->getXmlForField(1));
    }

    /**
     * test that the plugin only accepts JForm objects as input
     *
     * @param   mixed  $form  form object
     *
     * @dataProvider formDataProvider
     *
     * @return void;
     */
    public function testPluginReturnsFalseIfArgumentIsNoJform($form)
    {
        $this->assertFalse($this->object->onContentPrepareForm($form));
    }

    /**
     * test that the plugin only modifies the correct form
     *
     * @param   mixed  $formName  form name
     *
     * @dataProvider formNameDataProvider
     *
     * @return void
     */
    public function testPluginReturnsFalseOnWrongJFormName($formName)
    {
        $form = $this->getMockBuilder('JForm')->disableOriginalConstructor()->getMock();
        $form->expects($this->once())->method('getName')->willReturn($formName);

        $this->object->onContentPrepareForm($form);
    }

    /**
     * test if plugin fetches field cound from params
     *
     * @return void
     */
    public function testPluginFetchesFieldCountFromParams()
    {
        // Params mock
        $params = new \Joomla\Registry\Registry(array("imagecount" => 3));
        $this->object->params = $params;

        // Form mock
        $form = $this->getMockBuilder('JForm')->disableOriginalConstructor()->getMock();
        $form->expects($this->once())->method('getName')->willReturn('com_content.article');

        // Ensure that the XML generation method is called exactly 3 times
        $this->object->expects($this->exactly(3))->method('getXmlForField');

        $this->object->onContentPrepareForm($form);
    }

    /**
     * test if the result XML is correct
     *
     * @return void
     */
    public function testPluginConcatsXmlCorrectly()
    {
        $expectedXml = '<?xml version="1.0" encoding="utf-8"?><form><fields name="images" label="COM_CONTENT_FIELD_IMAGE_OPTIONS">';
        $expectedXml .= 'fieldxml</fields></form>';

        // Params mock
        $params = new \Joomla\Registry\Registry(array("imagecount" => 1));
        $this->object->params = $params;

        // Form mock
        $form = $this->getMockBuilder('JForm')->disableOriginalConstructor()->getMock();
        $form->method('getName')->willReturn('com_content.article');
        $form->expects($this->once())->method('load')->with($expectedXml);

        // Return string
        $this->object->method('getXmlForField')->willReturn('fieldxml');

        $this->assertTrue($this->object->onContentPrepareForm($form));
    }

    /**
     * returns data for JForm casting tests
     *
     * @return array
     */
    public function formDataProvider()
    {
        return array(
            array('<?xml version="1.0" encoding="utf-8"?><form></form>'),
            array(24),
            array(new stdClass),
            array(array()),
            array(true)
        );
    }

    /**
     * returns data for JForm name tests
     *
     * @return array
     */
    public function formNameDataProvider()
    {
        return array(
            array("content"),
            array("article"),
            array("content.article"),
            array(null),
            array(true)
        );
    }
}