import { describe, it, expect } from 'vitest'

import { mount } from '@vue/test-utils'
import CampaignPicker from '../campaign-picker/CampaignPicker.vue'

describe('CampaignPicker', () => {
    it('renders properly', () => {
        const wrapper = mount(CampaignPicker, { props: { msg: 'Hello Vitest' } })
        expect(wrapper.text()).toContain('Hello Vitest')
    })
})
