<script setup lang="ts">
import KebabMenu from '../kebab-menu/KebabMenu.vue'
import { type LinkInterface, LinkInterfaceTypeEnum } from '../../components/interfaces/link-interface';

const props = defineProps<{
    headings: string[]
    entities: Record<string, string>[]
}>()

// function confirmDelete(campaignId: number) {
//   console.debug('Confirming delete for ' + campaignId)
//   if (window.confirm('Are you sure you want to delete ' + campaignId + ': "' + campaignStore.getCampaignById(campaignId)?.name + '"')) {
//     console.debug('Confirmed - attempting delete')
//     campaignStore.deleteCampaign(campaignId)
//   }
// }

// function getLinks(campaign: CampaignEntityInterface): LinkInterface[] {
//   return [
//     {
//       label: 'Edit',
//       type: LinkInterfaceTypeEnum.ROUTER,
//       destination: {name: 'campaigns.edit', params: { externalCampaignId: campaign.id }},
//     },
//     {
//       label: 'Delete',
//       type: LinkInterfaceTypeEnum.BUTTON,
// //       function: ((campaign.id!) => {
// //   console.debug('Confirming delete for ' + campaignId)
// //   if (window.confirm('Are you sure you want to delete ' + campaignId)) {
// //     console.debug('Confirmed - attempting delete')
// //     campaignStore.deleteCampaign(campaignId)
// //   }
// // })
//       function: {
//         func: confirmDelete,
//         args: [campaign.id],
//       }
//     }
//   ]
// }

</script>

<template>
    <div>
        <table class="list-table">
            <thead>
                <tr>
                    <th v-for="heading in props.headings">{{ heading }}</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="entity in props.entities">
                    <td v-for="field in props.headings">{{ entity[field] }}</td>
                    <td class="action-cell">
                        <!-- <KebabMenu :links="getLinks(campaign)" /> -->
                        <!-- <div> -->
                        <!-- <router-link :to="{ name: 'campaigns.edit', params: { externalCampaignId: campaign.id }}">Edit</router-link> -->
                        <!-- </div> -->
                        <!-- <div> -->
                        <!-- <button class="destructive-button" @click="confirmDelete(campaign.id!)">Delete</button> -->
                        <!-- </div> -->
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>