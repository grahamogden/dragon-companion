<script setup lang="ts">
  import PrimaryButton from '../../Components/buttons/PrimaryButton.vue'
  import PageHeader from '../../Components/page-header/PageHeader.vue'
  import BaseInput from '../../Components/Fields/BaseInput.vue'
  import SimpleContainerSlimLayout from '../../Layouts/SimpleContainerSlimLayout.vue'
  import BaseLayout from '../../Layouts/BaseLayout.vue'
  import { Head, Link, useForm } from '@inertiajs/vue3'

  defineOptions({
    layout: [BaseLayout, SimpleContainerSlimLayout],
  })

  const form = useForm({
    email: '',
    password: '',
    remember: false,
  });

  const submit = () => {
    form.post(route('creator.login'), {
      onFinish: () => {
        form.reset('password');
      },
    });
  }
</script>

<template>

  <Head title="Log in" />
  <PageHeader>Log in</PageHeader>
  <form @submit.prevent="submit" class="flex flex-col gap-default md:gap-default-md">
    <BaseInput type="email" input-name="email" label="Email" v-model:model="form.email" :error="form.errors.email">
    </BaseInput>
    <BaseInput type="password" input-name="password" label="Password" v-model:model="form.password"
      :error="form.errors.password"></BaseInput>
    <div class="mt-10 flex flex-col md:flex-row justify-center gap-x-10 gap-y-default md:gap-y-default-md">
      <div class="md:order-last">
        <PrimaryButton text="Log in"></PrimaryButton>
      </div>
      <div class="w-full md:w-auto text-center">
        <Link href="/" class="my-2">Cancel</Link>
      </div>
    </div>
  </form>
</template>
