<?php

namespace App\Entity;

use App\Repository\ConfigurationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConfigurationRepository::class)]
class Configuration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $logo_url = null;

    #[ORM\Column(length: 255)]
    private ?string $footer_text = null;

    #[ORM\Column(length: 255)]
    private ?string $meta_title = null;

    #[ORM\Column(length: 255)]
    private ?string $meta_description = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $keywords = [];

    #[ORM\Column]
    private ?bool $enable_ads = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $analytics_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLogoUrl(): ?string
    {
        return $this->logo_url;
    }

    public function setLogoUrl(string $logo_url): static
    {
        $this->logo_url = $logo_url;

        return $this;
    }

    public function getFooterText(): ?string
    {
        return $this->footer_text;
    }

    public function setFooterText(string $footer_text): static
    {
        $this->footer_text = $footer_text;

        return $this;
    }

    public function getMetaTitle(): ?string
    {
        return $this->meta_title;
    }

    public function setMetaTitle(string $meta_title): static
    {
        $this->meta_title = $meta_title;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->meta_description;
    }

    public function setMetaDescription(string $meta_description): static
    {
        $this->meta_description = $meta_description;

        return $this;
    }

    public function getKeywords(): array
    {
        return $this->keywords;
    }

    public function setKeywords(array $keywords): static
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function isEnableAds(): ?bool
    {
        return $this->enable_ads;
    }

    public function setEnableAds(bool $enable_ads): static
    {
        $this->enable_ads = $enable_ads;

        return $this;
    }

    public function getAnalyticsId(): ?string
    {
        return $this->analytics_id;
    }

    public function setAnalyticsId(?string $analytics_id): static
    {
        $this->analytics_id = $analytics_id;

        return $this;
    }
}
