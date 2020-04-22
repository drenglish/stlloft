import { registerBlockType } from '@wordpress/blocks'
import { useEntityProp } from '@wordpress/core-data'
import { useSelect } from '@wordpress/data'
import { TextControl } from '@wordpress/components'
// import { PlainText, RichText, MediaPlaceholder } from '@wordpress/block-editor'

registerBlockType('real-blocks/listing', {
  title: 'Listing',
  icon: 'admin-network',
  category: 'layout',

  edit ( { className, attributes, setAttributes } ) {
    const postType = useSelect(
      (select) => select('core/editor').getCurrentPostType(),
      []
    )
    const [ meta, setMeta ] = useEntityProp('postType', postType, 'meta')
    return (
      <div className={ className }>
        <TextControl
          label="Listing title"
          value={ meta['myguten_meta_block_field'] }
          onChange={ title => setMeta( {...meta, 'myguten_meta_block_field': title} ) }
        />
      </div>
    )
  },
  save ( props ) {
    return null
  }
})
