
export interface PropertyImage {
  coverImage: string,
  allImages?: string[],
}

export interface Property  {
  id: number,
  location: string,
  description: string,
  beds:number,
  baths: number,
  garages: number,
  buying: boolean,
  imageList: PropertyImage,
  price:number,
  name:string,
  interested: boolean
}

export interface State {
  list: Property[],
  viewing: number,
  buying: boolean,
  interested: number[]
}
