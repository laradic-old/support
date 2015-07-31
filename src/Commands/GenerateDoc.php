<?php

namespace Laradic\Support\Commands;

use Illuminate\Console\Command;
use phpDocumentor\Reflection\DocBlock\Tag\ParamTag;
use phpDocumentor\Reflection\DocBlock\Tag\ReturnTag;
use ReflectionClass;


class GenerateDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laradic:support-doc {type=string}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dev command to generate docblock for some classes';

    protected $methodDoc = [ ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        switch ( $this->argument('type') )
        {
            case 'string':
                $this->info($this->genStringDoc());
                break;
            case 'array':
                $this->info($this->genArrayDoc());
                break;
        }
    }

    protected function genArrayDoc()
    {
        $this->methodDoc = [ ];
        $classes         = [ 'Underscore\Methods\ArraysMethods', 'Illuminate\Support\Arr' ];

        foreach ( $classes as $className )
        {
            $class   = new ReflectionClass($className);
            $methods = $class->getMethods();

            foreach ( $methods as $method )
            {
                if ( in_array($method->getName(), [ '__construct', '__toString', '__callStatic', '__call', 'create', 'unflatten', 'pull', 'set', 'forget' ], true) )
                {
                    continue;
                }
                $phpdoc = new \phpDocumentor\Reflection\DocBlock($method);

                $params = [ ];
                if ( $className === 'Underscore\Methods\ArraysMethods' )
                {
                    $params[] = 'array $subject';
                }

                foreach ( $phpdoc->getTagsByName('param') as $param )
                {
                    /** @var ParamTag $param */
                    $type = $param->getType();
                    if ( count($param->getTypes()) > 1 )
                    {
                        $type = 'mixed';
                    }
                    $str = $type . ' ';
                    foreach ( $method->getParameters() as $rp )
                    {
                        if ( $param->getVariableName() === '$' . $rp->getName() )
                        {
                            if ( $rp->isPassedByReference() )
                            {
                                $str .= '&';
                            }
                            $str .= $param->getVariableName();

                            if ( $rp->isDefaultValueAvailable() )
                            {
                                $def = $rp->getDefaultValue();
                                if ( is_null($def) )
                                {
                                    $str .= ' = null';
                                }
                                elseif ( is_array($def) )
                                {
                                    $str .= ' = []';
                                }
                                elseif ( is_string($def) )
                                {
                                    $str .= " = '$def'";
                                }
                            }
                            break;
                        }
                    }
                    $params[] = $str;
                }

                $this->addMethodDoc($method->getName(), $params, $phpdoc);
            }
        }

        return implode("\n", $this->methodDoc);
    }

    public function genStringDoc()
    {
        $this->methodDoc = [ ];
        $classes         = [ 'Underscore\Methods\StringMethods', 'Laradic\Support\Stringy\Stringy' ];

        foreach ( $classes as $className )
        {
            $class   = new ReflectionClass($className);
            $methods = $class->getMethods();

            foreach ( $methods as $method )
            {
                if ( in_array($method->getName(), [ '__construct', '__toString', '__callStatic', '__call', 'create' ], true) )
                {
                    continue;
                }

                $params = [ ];
                if ( $className === 'Laradic\Support\Stringy\Stringy' )
                {
                    $params[] = 'string $subject';
                }
                $phpdoc = new \phpDocumentor\Reflection\DocBlock($method);
                foreach ( $phpdoc->getTagsByName('param') as $param )
                {
                    /** @var ParamTag $param */
                    $type = $param->getType();
                    if ( $type === 'array|string' )
                    {
                        $type = 'mixed';
                    }
                    $str = $type . ' ';

                    foreach ( $method->getParameters() as $rp )
                    {
                        if ( $param->getVariableName() === '$' . $rp->getName() )
                        {
                            if ( $rp->isPassedByReference() )
                            {
                                $str .= '&';
                            }
                            $str .= $param->getVariableName();

                            if ( $rp->isDefaultValueAvailable() )
                            {
                                $def = $rp->getDefaultValue();
                                if ( is_null($def) )
                                {
                                    $str .= ' = null';
                                }
                                elseif ( is_array($def) )
                                {
                                    $str .= ' = []';
                                }
                                elseif ( is_string($def) )
                                {
                                    $str .= " = '$def'";
                                }
                            }
                            break;
                        }
                    }
                    $params[] = $str;
                }
                if(count($params) === 0){

                    $params[] = 'string $subject';
                }

                $this->addMethodDoc($method->getName(), $params, $phpdoc);
            }
        }

        return implode("\n", $this->methodDoc);
    }

    /**
     * addMethodDoc
     *
     */
    protected function addMethodDoc($methodName, array $params = [ ], \phpDocumentor\Reflection\DocBlock $phpdoc)
    {
        $returns = 'mixed';

        if ( $phpdoc->hasTag('return') )
        {
            /** @var ReturnTag $tag */
            $tag     = $phpdoc->getTagsByName('return')[ 0 ];
            $returns = $tag->getType();
            if ( in_array($returns, [ '\Stringy', '\Laradic\Support\Stringy\Stringy' ], true) )
            {
                $returns = 'string';
            }
        }

        $doc = ' * @method static ' . $returns . ' ';
        $doc .= $methodName;

        $doc .= '(';
        $doc .= implode(',', $params);
        $doc .= ')';
        $doc .= ' ' . str_replace("\n", ' ', $phpdoc->getShortDescription());

        $this->methodDoc[ $methodName ] = $doc;
    }
}
