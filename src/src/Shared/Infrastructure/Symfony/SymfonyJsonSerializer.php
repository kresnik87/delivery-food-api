<?php
declare(strict_types=1);
namespace KsK\Shared\Infrastructure\Symfony;
use KsK\Shared\Domain\JsonSerializerInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SymfonyJsonSerializer implements JsonSerializerInterface
{
  const FORMAT='json';
  private Serializer $serializer;

  public function __construct()
  {
    $encoders = [new JsonEncode()];
    $classMetadataFactory= new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
    $normalizers =[
      new DateTimeNormalizer(),
      new JsonSerializableNormalizer($classMetadataFactory, new CamelCaseToSnakeCaseNameConverter()),
      new ObjectNormalizer(
        $classMetadataFactory,
        new CamelCaseToSnakeCaseNameConverter(),
        null,
        null,
        new ClassDiscriminatorFromClassMetadata($classMetadataFactory)
      ),
    ];
    $this->serializer= new Serializer($normalizers,$encoders);
  }

  public function encode(mixed $data, array $context = []): string
  {
    return $this->serializer->serialize($data,self::FORMAT,$context);
  }
}
