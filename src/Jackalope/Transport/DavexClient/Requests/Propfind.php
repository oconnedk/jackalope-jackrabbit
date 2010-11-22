<?php
/**
 * Class to handle the communication between Jackalope and Jackrabbit via Davex.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0, January 2004
 *   Licensed under the Apache License, Version 2.0 (the "License");
 *   you may not use this file except in compliance with the License.
 *   You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 *   Unless required by applicable law or agreed to in writing, software
 *   distributed under the License is distributed on an "AS IS" BASIS,
 *   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *   See the License for the specific language governing permissions and
 *   limitations under the License.
 *
 * @package jackalope
 * @subpackage transport
 */

namespace Jackalope\Transport\DavexClient\Requests;

/**
 * Class to handle a PROPFIND request.
 *
 * @package jackalope
 * @subpackage transport
 */
class Propfind extends \Jackalope\Transport\DavexClient\Requests\Base
{
    /**
     * Identifier of the used XML namespace
     * @var array
     */
    protected $nsInformation = array(
        'D'   => 'DAV:',
        'dcr' => 'http://www.day.com/jcr/webdav/1.0'
    );

    /**
     * Generates the DOMDocument representing the request to be send.
     *
     * Available properties:
     *  - D:workspace
     *  - dcr:workspaceName
     *
     * @throws \InvalidArgumentException
     */
    public function build()
    {
        if (empty($this->arguments['properties'])) {
            throw new \InvalidArgumentException('Missing Properties.');
        }

        // root element
        // <D:propfind xmlns:D="DAV:" xmlns:dcr="http://www.day.com/jcr/webdav/1.0">
        $doc = $this->dom->createElementNS($this->nsInformation['D'], 'D:propfind');

        // set 2nd namspace to root element.
        $doc->setAttributeNS('http://www.w3.org/2000/xmlns/' , 'xmlns:dcr', $this->nsInformation['dcr']);

        // elemente
        $prop = $this->dom->createElement('D:prop');

        if (!is_array($this->arguments['properties'])) {
            $this->arguments['properties'] = array($this->arguments['properties']);
        }

        foreach($this->arguments['properties'] as $property) {
            $propElement = $this->dom->createElement($property);
            $prop->appendChild($propElement);
        }

        $doc->appendChild($prop);
        $this->dom->appendChild($doc);
    }
}