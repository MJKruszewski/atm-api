<?php

namespace tests\Converter;

include_once '../Mocks/SampleDto.php';

use App\Converter\DtoConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use tests\Mocks\SampleDto;

class DtoConverterTest extends TestCase
{

    /**
     * @var DtoConverter
     */
    private $dtoConverter;

    /**
     * @before
     */
    public function setupConverter(): void
    {
        $this->dtoConverter = new DtoConverter(new \Symfony\Component\HttpKernel\Tests\Logger());
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf(DtoConverter::class, $this->dtoConverter);
    }

    /**
     * @dataProvider paramConverterProvider
     *
     * @param bool $expectedBool
     * @param string|null $expectedClass
     * @param array $params
     * @param array|null $requestParams
     */
    public function testApply(
        bool $expectedBool,
        ?string $expectedClass,
        array $params
    ): void
    {
        $request = new Request();
        $converter = new ParamConverter($params);

        $result = $this->dtoConverter->apply($request, $converter);
        $resultClass = $request->get($converter->getName());

        $this->assertEquals($expectedBool, $result);
        if ($resultClass || $expectedClass) {
            $this->assertInstanceOf($expectedClass, $resultClass);
        } else {
            $this->assertNull($resultClass);
        }
    }

    /**
     * @dataProvider dtoValuesProvider
     *
     * @param array $params
     * @param array $requestParams
     * @param array $expectedParams
     */
    public function testDtoValues(array $params, array $requestParams, array $expectedParams): void
    {
        $request = new Request();
        $converter = new ParamConverter($params);

        foreach ($requestParams as $key => $param) {
            $request->attributes->set($key, $param);
        }

        $result = $this->dtoConverter->apply($request, $converter);
        $resultClass = $request->get($converter->getName());

        $this->assertInstanceOf(SampleDto::class, $resultClass);
        $this->assertTrue($result);

        foreach ($requestParams as $key => $expectedParam) {
            $this->assertNull($request->get($key));
        }

        foreach ($expectedParams as $key => $param) {
            $method = 'get' . ucfirst($key);
            $this->assertEquals($param, $resultClass->{$method}());
            $this->assertAttributeInternalType(gettype($param), $key, $resultClass);
        }

    }

    public function testSupport(): void
    {
        $converter = new ParamConverter([]);
        $this->assertTrue($this->dtoConverter->supports($converter));
    }

    /**
     * @return array
     */
    public function paramConverterProvider(): array
    {
        return [
            [false, null, []],
            [true, null, ['isOptional' => true]],
            [true, 'tests\Mocks\SampleDto', ['name' => 'sampleName', 'class' => 'tests\Mocks\SampleDto']]
        ];
    }

    public function dtoValuesProvider(): array
    {
        return [
            [
                ['name' => 'sampleName', 'class' => 'tests\Mocks\SampleDto'],
                ['id' => 'uuid', 'amount' => 11.11, 'bool' => false, 'number' => 1, 'test' => null, 'broken' => 111],
                ['id' => 'uuid', 'amount' => 11.11, 'bool' => false, 'number' => 1]
            ],
            [
                ['name' => 'sampleName', 'class' => 'tests\Mocks\SampleDto'],
                ['id' => 'uuid', 'amount' => '10.55', 'bool' => false, 'number' => ' 5555', 'test' => null, 'broken' => 111],
                ['id' => 'uuid', 'amount' => 10.55, 'bool' => false, 'number' => 5555]
            ],
        ];
    }

}
