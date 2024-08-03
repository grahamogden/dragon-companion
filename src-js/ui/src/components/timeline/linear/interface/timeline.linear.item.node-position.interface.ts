export enum NodePositionEnum {
    start = 'start',
    end = 'end',
    both = 'both',
}

export default interface TimelineLinearItemNodePositionInterface {
    truncateLine: NodePositionEnum
}
